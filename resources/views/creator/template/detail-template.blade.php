                            <div class="modal fade creator-template-modal" id="templateModal{{ $template->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div>
                                                <h5 class="modal-title mb-1">{{ $template->title }}</h5>
                                                <small class="text-muted">Detail template milik {{ $template->user->name }}</small>
                                            </div>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="creator-template-preview-stack">
                                                        <div class="creator-template-preview-card">
                                                            <div class="creator-template-preview-label">Preview Image</div>
                                                            <div class="creator-template-preview-media">
                                                                <img src="{{ asset('storage/' . $template->preview) }}"
                                                                    alt="{{ $template->title }}">
                                                            </div>
                                                        </div>

                                                        @if ($template->preview_video)
                                                            <div class="creator-template-preview-card">
                                                                <div class="creator-template-preview-label">Preview Video</div>
                                                                <div class="creator-template-preview-media creator-template-preview-video">
                                                                    <video
                                                                        controls
                                                                        playsinline
                                                                        preload="metadata"
                                                                        class="creator-template-video-player"
                                                                        data-duration-target="videoDuration{{ $template->id }}">
                                                                        <source src="{{ asset('storage/' . $template->preview_video) }}">
                                                                    </video>
                                                                </div>
                                                                <div class="creator-template-video-meta">
                                                                    <span>Durasi video</span>
                                                                    <span class="creator-template-video-duration" id="videoDuration{{ $template->id }}">Memuat...</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="creator-template-panel">
                                                        <div class="creator-template-badges">
                                                            <span class="creator-template-badge">{{ ucfirst($template->type) }}</span>
                                                            <span class="creator-template-badge">{{ $template->category->name ?? 'Tanpa kategori' }}</span>
                                                        </div>

                                                        <div class="creator-template-price">
                                                            {{ $template->price == 0 ? 'Gratis' : 'Rp ' . number_format($template->price, 0, ',', '.') }}
                                                        </div>

                                                        <div class="creator-template-meta">

                                                            <div class="creator-template-meta-item">
                                                                <span class="creator-template-meta-label">Software</span>
                                                                <div class="creator-template-meta-value">{{ $template->software->name ?? '-' }}</div>
                                                            </div>

                                                            <div class="creator-template-meta-item">
                                                                <span class="creator-template-meta-label">Download</span>
                                                                <div class="creator-template-meta-value">{{ number_format($template->download_count ?? 0) }} kali</div>
                                                            </div>

                                                            <div class="creator-template-meta-item">
                                                                <span class="creator-template-meta-label">Rating</span>
                                                                <div class="creator-template-meta-value">{{ number_format($template->average_rating ?? 0, 1) }} / 5</div>
                                                            </div>
                                                        </div>

                                                        <div class="creator-template-description">
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