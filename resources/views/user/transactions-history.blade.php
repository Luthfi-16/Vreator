@extends('layouts.user')

@section('content')

@php
    $totalTransaksi = $transactions->count();
    $totalPaid = $transactions->where('status', 'paid')->count();
    $totalPengeluaran = $transactions->where('status', 'paid')->sum('total_price');
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

    body, .user-layout {
        background: #F5F0E8 !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .page-content {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2.5rem 1.5rem;
    }

    .section-title {
        font-size: 26px;
        font-weight: 600;
        color: #1A1A1A;
        letter-spacing: -0.5px;
        margin-bottom: 4px;
    }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        border: 0.5px solid rgba(0,0,0,0.07);
    }

    .stat-label {
        font-size: 12px;
        color: #999;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 600;
        color: #1A1A1A;
    }

    .stat-value.orange { color: #E07B39; }
    .stat-value.green  { color: #2E7D32; }

    /* Main Card */
    .trx-card {
        background: #fff;
        border-radius: 16px;
        border: 0.5px solid rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .trx-card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 0.5px solid rgba(0,0,0,0.07);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .trx-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #1A1A1A;
    }

    /* Filter Buttons */
    .filter-row { display: flex; gap: 8px; }

    .filter-btn {
        font-size: 12px;
        padding: 5px 14px;
        border-radius: 20px;
        border: 0.5px solid rgba(0,0,0,0.12);
        background: transparent;
        color: #666;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s;
        text-decoration: none;
    }

    .filter-btn:hover { background: #F5F0E8; color: #333; }

    .filter-btn.active {
        background: #E07B39;
        color: #fff;
        border-color: #E07B39;
    }

    /* Table */
    .trx-table { width: 100%; border-collapse: collapse; }

    .trx-table thead th {
        font-size: 12px;
        font-weight: 500;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 0.85rem 1.5rem;
        text-align: left;
        background: #FAFAF8;
        border-bottom: 0.5px solid rgba(0,0,0,0.06);
    }

    .trx-table thead th:last-child { text-align: right; }

    .trx-table tbody tr {
        border-bottom: 0.5px solid rgba(0,0,0,0.05);
        transition: background 0.1s;
    }

    .trx-table tbody tr:last-child { border-bottom: none; }
    .trx-table tbody tr:hover { background: #FAFAF8; }

    .trx-table td {
        padding: 1rem 1.5rem;
        font-size: 14px;
        color: #333;
        vertical-align: middle;
    }

    .trx-table td:last-child { text-align: right; }

    /* Template Cell */
    .template-cell { display: flex; align-items: center; gap: 12px; }

    .template-cell img {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .tmpl-name {
        font-size: 14px;
        font-weight: 600;
        color: #1A1A1A;
        margin-bottom: 2px;
    }

    .tmpl-creator { font-size: 12px; color: #999; }

    /* Order ID */
    .order-id {
        font-size: 12px;
        font-family: monospace;
        color: #E07B39;
        background: #FEF3EA;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-block;
    }

    /* Price */
    .price { font-weight: 600; color: #1A1A1A; }

    /* Badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .badge-status.paid    { background: #E8F5E9; color: #2E7D32; }
    .badge-status.pending { background: #FFF8E1; color: #E65100; }
    .badge-status.failed  { background: #FFEBEE; color: #C62828; }

    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-status.paid    .badge-dot { background: #2E7D32; }
    .badge-status.pending .badge-dot { background: #E65100; }
    .badge-status.failed  .badge-dot { background: #C62828; }

    /* Date */
    .date-text { font-size: 13px; color: #888; }

    /* Action Buttons */
    .btn-group {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-trx {
        font-size: 13px;
        font-weight: 500;
        padding: 7px 14px;
        border-radius: 8px;
        border: 0.5px solid rgba(0,0,0,0.12);
        background: transparent;
        color: #555;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-trx:hover { background: #F5F0E8; color: #333; }

    .btn-trx.success {
        background: #2E7D32;
        color: #fff;
        border-color: #2E7D32;
    }

    .btn-trx.success:hover { background: #256328; }

    .btn-trx.warning {
        background: #FFF8E1;
        color: #E65100;
        border-color: #FFCC80;
    }

    .btn-trx.warning:hover { background: #FFECB3; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
        color: #BBB;
        font-size: 14px;
    }

    .empty-state svg { margin-bottom: 12px; opacity: 0.3; }

    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .trx-table thead th:nth-child(2),
        .trx-table td:nth-child(2) { display: none; }
        .filter-row { display: none; }
    }
</style>

<div class="page-content">

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info mb-4">{{ session('info') }}</div>
    @endif

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="section-title">Riwayat Transaksi</h1>
        <p class="text-muted mb-0" style="font-size:14px;">Lacak pembayaran dan lanjutkan transaksi yang masih pending.</p>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value orange">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Berhasil Dibayar</div>
            <div class="stat-value green">{{ $totalPaid }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Pengeluaran</div>
            <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="trx-card">
        <div class="trx-card-header">
            <div class="trx-card-title">Semua Transaksi</div>
            <div class="filter-row">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="paid">Paid</button>
                <button class="filter-btn" data-filter="pending">Pending</button>
                <button class="filter-btn" data-filter="failed">Failed</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Template</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="trx-tbody">
                    @forelse ($transactions as $transaction)
                        <tr data-status="{{ $transaction->status }}">
                            <td>
                                <div class="template-cell">
                                    <img src="{{ asset('storage/' . $transaction->template->preview) }}"
                                         alt="{{ $transaction->template->title }}">
                                    <div>
                                        <div class="tmpl-name">{{ $transaction->template->title }}</div>
                                        <div class="tmpl-creator">{{ $transaction->template->user->name ?? 'Creator' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="order-id">{{ $transaction->order_id }}</span></td>
                            <td><span class="price">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></td>
                            <td>
                                @php
                                    $statusClass = match ($transaction->status) {
                                        'paid'    => 'paid',
                                        'failed'  => 'failed',
                                        default   => 'pending',
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">
                                    <span class="badge-dot"></span>
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="date-text">
                                    {{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y · H:i') }} WIB
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('user.template.show', $transaction->template) }}"
                                       class="btn-trx">Detail</a>

                                    @if ($transaction->status === 'pending')
                                        <button type="button"
                                                class="btn-trx warning js-resume-payment"
                                                data-url="{{ route('user.transactions.resume', $transaction) }}">
                                            Lanjutkan
                                        </button>
                                    @elseif ($transaction->status === 'paid')
                                        <a href="{{ route('user.template.download', $transaction->template) }}"
                                           class="btn-trx success">
                                            Download
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <rect x="6" y="8" width="28" height="24" rx="4" stroke="#999" stroke-width="1.5"/>
                                        <path d="M13 16h14M13 21h10" stroke="#999" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <p>Belum ada transaksi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Midtrans --}}
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            document.querySelectorAll('#trx-tbody tr[data-status]').forEach(row => {
                row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
            });
        });
    });

    // Resume payment
    document.querySelectorAll('.js-resume-payment').forEach(button => {
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
                    onSuccess: function (result) {
                        window.location.href = '/user/payment/success?order_id=' + result.order_id;
                    },
                    onPending: function (result) {
                        window.location.href = '/user/payment/success?order_id=' + result.order_id;
                    },
                    onClose: function () {
                        alert('Pembayaran masih pending. Kamu bisa lanjutkan lagi dari riwayat transaksi.');
                    },
                    onError: function () {
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
