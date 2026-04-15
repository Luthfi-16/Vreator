@extends('layouts.creator')

@section('content')
<style>
    .creator-template-modal .modal-content {
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(30, 41, 59, 0.16);
    }

    .creator-template-modal .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(135deg, #fff7ed, #ffffff);
    }

    .creator-template-modal .modal-body {
        padding: 24px;
    }

    .creator-template-preview-stack {
        display: grid;
        gap: 16px;
    }

    .creator-template-preview-card {
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: 1px solid #e5e7eb;
    }

    .creator-template-preview-label {
        padding: 10px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: rgba(255, 255, 255, 0.75);
        border-bottom: 1px solid #e5e7eb;
    }

    .creator-template-preview-media {
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
    }

    .creator-template-preview-media img,
    .creator-template-preview-media video {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .creator-template-preview-video {
        background: #0f172a;
    }

    .creator-template-preview-video video {
        object-fit: contain;
        background: #0f172a;
    }

    .creator-template-video-meta {
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

    .creator-template-video-duration {
        font-weight: 700;
        color: #0f172a;
    }

    .creator-template-panel {
        height: 100%;
        padding: 22px;
        border-radius: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }

    .creator-template-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .creator-template-badge {
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

    .creator-template-price {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 18px;
    }

    .creator-template-meta {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
    }

    .creator-template-meta-item {
        padding: 14px 16px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .creator-template-meta-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .creator-template-meta-value {
        color: #0f172a;
        font-weight: 600;
    }

    .creator-template-description {
        padding: 18px 20px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #e5e7eb;
    }

    .creator-template-description h6 {
        margin-bottom: 10px;
        font-weight: 700;
        color: #0f172a;
    }

    .creator-template-description p {
        margin-bottom: 0;
        color: #475569;
        line-height: 1.75;
    }

    @media (max-width: 991.98px) {
        .creator-template-preview-media {
            height: 220px;
        }
    }
</style>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Template Saya</h4>
        <a href="{{ route('creator.template.create') }}" class="btn btn-primary">
            + Tambah Template
        </a>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul Template</th>
                            <th>Harga</th>
                            <th>Tipe</th>
                            <th>Preview</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $template)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $template->title }}</strong>
                                    <div class="text-muted small">
                                        {{ Str::limit($template->description, 50) }}
                                    </div>
                                </td>

                                <td>
                                    @if ($template->price == 0)
                                        <span class="badge bg-success">Free</span>
                                    @else
                                        Rp {{ number_format($template->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    @if($template->type == 'video')
                                        Video
                                    @else
                                        Photo
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $template->preview) }}"
                                         alt="Preview"
                                         width="70"
                                         class="rounded shadow-sm">
                                </td>

                                <td class="text-end">
                                    <button class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#templateModal{{ $template->id }}">
                                        Detail
                                    </button>

                                    <a href="{{ route('creator.template.edit', $template) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('creator.template.destroy', $template) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus template ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @include('creator.template.detail-template')
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada template 😴
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const players = document.querySelectorAll('.creator-template-video-player');
        const modals = document.querySelectorAll('.creator-template-modal');

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
