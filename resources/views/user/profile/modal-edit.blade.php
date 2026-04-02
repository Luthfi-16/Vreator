<style>
    /* ── Modal Overlay ── */
    #editProfileModal .modal-dialog {
        max-width: 480px;
    }

    #editProfileModal .modal-content {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(0,0,0,0.14);
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Header ── */
    #editProfileModal .modal-header {
        background: linear-gradient(135deg, var(--vreator-orange, #E8821A) 0%, var(--vreator-orange-light, #F5A24B) 100%);
        border: none;
        padding: 22px 28px 20px;
        position: relative;
    }

    #editProfileModal .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: #fff;
        letter-spacing: -0.2px;
    }

    #editProfileModal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s, transform 0.2s;
    }

    #editProfileModal .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* ── Body ── */
    #editProfileModal .modal-body {
        background: #fff;
        padding: 28px 28px 8px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* ── Field Group ── */
    .vr-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .vr-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #E8821A;
    }

    .vr-input,
    .vr-textarea {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #EDE7DC;
        border-radius: 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #1A1208;
        background: #FDFAF6;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        resize: none;
    }

    .vr-input:focus,
    .vr-textarea:focus {
        border-color: #E8821A;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(232, 130, 26, 0.12);
    }

    .vr-textarea {
        min-height: 88px;
        line-height: 1.5;
    }

    /* ── Photo Upload ── */
    .vr-upload-label {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border: 1.5px dashed #DCCEBC;
        border-radius: 12px;
        background: #FDFAF6;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .vr-upload-label:hover {
        border-color: #E8821A;
        background: #FFF4E8;
    }

    .vr-upload-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(232,130,26,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #E8821A;
    }

    .vr-upload-text strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1A1208;
        margin-bottom: 1px;
    }

    .vr-upload-text span {
        font-size: 11.5px;
        color: #8A7B6A;
    }

    #profile_photo_input {
        display: none;
    }

    .vr-upload-filename {
        font-size: 12px;
        color: #E8821A;
        font-weight: 500;
        margin-top: 6px;
        display: none;
    }

    /* ── Footer ── */
    #editProfileModal .modal-footer {
        background: #fff;
        border: none;
        padding: 12px 28px 24px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-vr-cancel {
        padding: 11px 22px;
        border-radius: 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: #8A7B6A;
        background: #F5F0E8;
        border: 1.5px solid #EDE7DC;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .btn-vr-cancel:hover {
        background: #EDE7DC;
        color: #1A1208;
    }

    .btn-vr-save {
        padding: 11px 26px;
        border-radius: 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #E8821A 0%, #F5A24B 100%);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(232,130,26,0.35);
        transition: transform 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-vr-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(232,130,26,0.45);
    }

    .btn-vr-save:active {
        transform: translateY(0);
    }
</style>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    {{-- Name --}}
                    <div class="vr-field">
                        <label class="vr-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="vr-input"
                               value="{{ auth()->user()->name }}"
                               placeholder="Nama lengkap"
                               required>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="vr-field">
                        <label class="vr-label">WhatsApp</label>
                        <input type="text"
                               name="whatsapp"
                               class="vr-input"
                               value="{{ auth()->user()->whatsapp }}"
                               placeholder="Contoh: 08123456789">
                    </div>

                    {{-- Bio --}}
                    <div class="vr-field">
                        <label class="vr-label">Bio</label>
                        <textarea name="bio"
                                  class="vr-textarea"
                                  placeholder="Ceritakan sedikit tentang dirimu…">{{ auth()->user()->bio }}</textarea>
                    </div>

                    {{-- Photo Upload --}}
                    <div class="vr-field">
                        <label class="vr-label">Foto Profil</label>
                        <label class="vr-upload-label" for="profile_photo_input">
                            <div class="vr-upload-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <div class="vr-upload-text">
                                <strong>Pilih foto baru</strong>
                                <span>JPG, PNG</span>
                            </div>
                        </label>
                        <input type="file"
                               name="profile_photo"
                               id="profile_photo_input"
                               accept="image/*">
                        <p class="vr-upload-filename" id="upload-filename"></p>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button"
                            class="btn-vr-cancel"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn-vr-save">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_photo_input').addEventListener('change', function () {
        const label = document.getElementById('upload-filename');
        if (this.files && this.files[0]) {
            label.textContent = '📎 ' + this.files[0].name;
            label.style.display = 'block';
        } else {
            label.style.display = 'none';
        }
    });
</script>