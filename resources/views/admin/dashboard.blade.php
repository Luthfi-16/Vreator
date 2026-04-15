@extends('layouts.creator')

@section('content')
<div class="page-heading mb-4">
    <h3>Admin Dashboard</h3>
    <p class="text-muted mb-0">Ringkasan data yang dikelola admin di Vreator.</p>
</div>

<div class="page-content">
    <section class="row g-4 mb-4">
        <div class="col-6 col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Template</p>
                    <h3 class="mb-1">{{ number_format($stats['templates']) }}</h3>
                    <small class="text-muted">{{ number_format($stats['downloads']) }} total download</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Service</p>
                    <h3 class="mb-1">{{ number_format($stats['services']) }}</h3>
                    <small class="text-muted">{{ number_format($stats['activeServices']) }} service aktif</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Creator</p>
                    <h3 class="mb-1">{{ number_format($stats['creators']) }}</h3>
                    <small class="text-muted">{{ number_format($stats['users']) }} user buyer</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Transaksi Sukses</p>
                    <h3 class="mb-1">{{ number_format($stats['paidTransactions']) }}</h3>
                    <small class="text-muted">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Aktivitas Konten</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 h-100">
                                <p class="text-muted small mb-1">Software</p>
                                <h4 class="mb-0">{{ number_format($stats['softwares']) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 h-100">
                                <p class="text-muted small mb-1">Kategori Template</p>
                                <h4 class="mb-0">{{ number_format($stats['categories']) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 h-100">
                                <p class="text-muted small mb-1">Service Aktif</p>
                                <h4 class="mb-0">{{ number_format($stats['activeServices']) }}</h4>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Template Paling Ramai</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Template</th>
                                    <th>Creator</th>
                                    <th>Download</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topTemplates as $template)
                                    <tr>
                                        <td>{{ $template->title }}</td>
                                        <td>{{ $template->user->name ?? '-' }}</td>
                                        <td>{{ number_format($template->download_count ?? 0) }}</td>
                                        <td>{{ number_format($template->average_rating ?? 0, 1) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada data template.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Ringkasan Moderasi</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>Total Template</span>
                        <strong>{{ number_format($stats['templates']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>Total Service</span>
                        <strong>{{ number_format($stats['services']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>Service Aktif</span>
                        <strong>{{ number_format($stats['activeServices']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>Software</span>
                        <strong>{{ number_format($stats['softwares']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span>Kategori</span>
                        <strong>{{ number_format($stats['categories']) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Template Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Template</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTemplates as $template)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $template->title }}</div>
                                            <small class="text-muted">oleh {{ $template->user->name ?? '-' }}</small>
                                        </td>
                                        <td>{{ $template->category->name ?? '-' }}</td>
                                        <td>{{ $template->price == 0 ? 'Gratis' : 'Rp ' . number_format($template->price, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Belum ada template.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Service Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Creator</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentServices as $service)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $service->title }}</div>
                                            <small class="text-muted">Rp {{ number_format($service->price, 0, ',', '.') }}</small>
                                        </td>
                                        <td>{{ $service->user->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $service->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Belum ada service.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
