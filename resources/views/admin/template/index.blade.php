@extends('layouts.creator')

@section('content')
<style>
    .admin-template-modal .modal-content {
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(30, 41, 59, 0.16);
    }

    .admin-template-modal .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(135deg, #fff7ed, #ffffff);
    }

    .admin-template-modal .modal-body {
        padding: 24px;
    }

    .admin-template-preview-stack {
        display: grid;
        gap: 16px;
    }

    .admin-template-preview-card {
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: 1px solid #e5e7eb;
    }

    .admin-template-preview-label {
        padding: 10px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: rgba(255, 255, 255, 0.75);
        border-bottom: 1px solid #e5e7eb;
    }

    .admin-template-preview-media {
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
    }

    .admin-template-preview-media img,
    .admin-template-preview-media video {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .admin-template-preview-video {
        background: #0f172a;
    }

    .admin-template-preview-video video {
        object-fit: contain;
        background: #0f172a;
    }

    .admin-template-video-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        font-size: 0.86rem;
        color: #475569;
        background: #fff;
        border-top: 1px solid #e5e7eb;
    }

    .admin-template-video-duration {
        font-weight: 700;
        color: #0f172a;
    }

    .admin-template-panel {
        height: 100%;
        padding: 22px;
        border-radius: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }

    .admin-template-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .admin-template-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        background: #fff;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .admin-template-price {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 18px;
    }

    .admin-template-meta {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
    }

    .admin-template-meta-item {
        padding: 14px 16px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .admin-template-meta-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .admin-template-meta-value {
        color: #0f172a;
        font-weight: 600;
    }

    .admin-template-description {
        padding: 18px 20px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .admin-template-description h6 {
        margin-bottom: 10px;
        font-weight: 700;
        color: #0f172a;
    }

    .admin-template-description p {
        margin-bottom: 0;
        color: #475569;
        line-height: 1.75;
    }

    @media (max-width: 991.98px) {
        .admin-template-preview-media {
            height: 220px;
        }
    }
</style>
<div class="container">
    <h4 class="fw-bold mb-4">All Templates</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Template</th>
                        <th>Creator</th>
                        <th>Price</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $template->title }}</td>
                        <td>{{ $template->user->name }}</td>
                        <td>Rp {{ number_format($template->price,0,',','.') }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#templateModal{{ $template->id }}">
                                Detail
                            </button>

                            <form action="{{ route('admin.template.destroy',$template->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade admin-template-modal" id="templateModal{{ $template->id }}">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title mb-1">{{ $template->title }}</h5>
                                        <small class="text-muted">Detail template dari {{ $template->user->name }}</small>
                                    </div>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="admin-template-preview-stack">
                                                <div class="admin-template-preview-card">
                                                    <div class="admin-template-preview-label">Preview Image</div>
                                                    <div class="admin-template-preview-media">
                                                        <img src="{{ asset('storage/'.$template->preview) }}"
                                                            alt="{{ $template->title }}">
                                                    </div>
                                                </div>

                                                @if($template->preview_video)
                                                    <div class="admin-template-preview-card">
                                                        <div class="admin-template-preview-label">Preview Video</div>
                                                        <div class="admin-template-preview-media admin-template-preview-video">
                                                            <video
                                                                controls
                                                                playsinline
                                                                preload="metadata"
                                                                class="admin-template-video-player"
                                                                data-duration-target="videoDuration{{ $template->id }}"
                                                            >
                                                                <source src="{{ asset('storage/' . $template->preview_video) }}">
                                                            </video>
                                                        </div>
                                                        <div class="admin-template-video-meta">
                                                            <span>Durasi video</span>
                                                            <span class="admin-template-video-duration" id="videoDuration{{ $template->id }}">Memuat...</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="admin-template-panel">
                                                <div class="admin-template-badges">
                                                    <span class="admin-template-badge">{{ ucfirst($template->type) }}</span>
                                                    <span class="admin-template-badge">{{ $template->category->name ?? 'Tanpa kategori' }}</span>
                                                </div>

                                                <div class="admin-template-price">
                                                    {{ $template->price == 0 ? 'Gratis' : 'Rp ' . number_format($template->price, 0, ',', '.') }}
                                                </div>

                                                <div class="admin-template-meta">
                                                    <div class="admin-template-meta-item">
                                                        <span class="admin-template-meta-label">Creator</span>
                                                        <div class="admin-template-meta-value">{{ $template->user->name }}</div>
                                                    </div>

                                                    <div class="admin-template-meta-item">
                                                        <span class="admin-template-meta-label">Software</span>
                                                        <div class="admin-template-meta-value">{{ $template->software->name ?? '-' }}</div>
                                                    </div>

                                                    <div class="admin-template-meta-item">
                                                        <span class="admin-template-meta-label">Download</span>
                                                        <div class="admin-template-meta-value">{{ number_format($template->download_count ?? 0) }} kali</div>
                                                    </div>

                                                    <div class="admin-template-meta-item">
                                                        <span class="admin-template-meta-label">Rating</span>
                                                        <div class="admin-template-meta-value">{{ number_format($template->average_rating ?? 0, 1) }} / 5</div>
                                                    </div>
                                                </div>

                                                <div class="admin-template-description">
                                                    <h6>Deskripsi Template</h6>
                                                    <p>{{ $template->description ?: 'Belum ada deskripsi untuk template ini.' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const players = document.querySelectorAll('.admin-template-video-player');
        const modals = document.querySelectorAll('.admin-template-modal');

        function formatDuration(totalSeconds) {
            if (!Number.isFinite(totalSeconds) || totalSeconds < 0) {
                return '--:--';
            }

            const seconds = Math.floor(totalSeconds % 60).toString().padStart(2, '0');
            const minutes = Math.floor((totalSeconds / 60) % 60).toString().padStart(2, '0');
            const hours = Math.floor(totalSeconds / 3600);

            return hours > 0
                ? `${hours}:${minutes}:${seconds}`
                : `${minutes}:${seconds}`;
        }

        players.forEach(function (player) {
            const targetId = player.dataset.durationTarget;
            const target = targetId ? document.getElementById(targetId) : null;

            if (!target) {
                return;
            }

            const syncDuration = function () {
                target.textContent = formatDuration(player.duration);
            };

            player.addEventListener('loadedmetadata', syncDuration);
            player.addEventListener('durationchange', syncDuration);

            if (player.readyState >= 1) {
                syncDuration();
            }
        });

        modals.forEach(function (modal) {
            modal.addEventListener('hidden.bs.modal', function () {
                modal.querySelectorAll('video').forEach(function (video) {
                    video.pause();
                    video.currentTime = 0;
                });
            });
        });
    });
</script>
@endsection
