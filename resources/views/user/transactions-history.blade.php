@extends('layouts.user')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="section-title mb-1">Riwayat Transaksi</h1>
        <p class="text-muted mb-0">Lacak pembayaran dan lanjutkan transaksi yang masih pending.</p>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Template</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $transaction->template->preview) }}"
                                        alt="{{ $transaction->template->title }}"
                                        style="width: 56px; height: 56px; object-fit: cover; border-radius: 12px;">
                                    <div>
                                        <div class="fw-semibold">{{ $transaction->template->title }}</div>
                                        <small class="text-muted">{{ $transaction->template->user->name ?? 'Creator' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $transaction->order_id }}</code></td>
                            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match ($transaction->status) {
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        default => 'warning text-dark',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($transaction->status) }}</span>
                            </td>
                            <td>{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                            <td class="text-end">
                                <a href="{{ route('user.template.show', $transaction->template) }}" class="btn btn-outline-secondary btn-sm">
                                    Detail
                                </a>
                                @if ($transaction->status === 'pending')
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm js-resume-payment"
                                        data-url="{{ route('user.transactions.resume', $transaction) }}">
                                        Lanjutkan Pembayaran
                                    </button>
                                @elseif ($transaction->status === 'paid')
                                    <a href="{{ route('user.template.download', $transaction->template) }}" class="btn btn-success btn-sm">
                                        Download
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const resumeButtons = document.querySelectorAll('.js-resume-payment');

    resumeButtons.forEach((button) => {
        button.addEventListener('click', async function () {
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Memuat...';

            try {
                const response = await fetch(button.dataset.url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok || !data.snap_token) {
                    alert(data.message || 'Transaksi tidak bisa dilanjutkan.');
                    window.location.reload();
                    return;
                }

                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = "/user/payment/success?order_id=" + result.order_id;
                    },
                    onPending: function(result) {
                        window.location.href = "/user/payment/success?order_id=" + result.order_id;
                    },
                    onClose: function() {
                        alert('Pembayaran masih pending. Kamu bisa lanjutkan lagi dari riwayat transaksi.');
                    },
                    onError: function() {
                        alert('Pembayaran gagal.');
                    }
                });
            } catch (error) {
                alert('Gagal menghubungi server.');
            } finally {
                button.disabled = false;
                button.textContent = originalText;
            }
        });
    });
});
</script>
@endsection
