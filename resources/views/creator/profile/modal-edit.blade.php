<style>
    @import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;600&family=Outfit:wght@300;400;500;600&display=swap');

    #editProfileModalCreator .modal-dialog {
        max-width: 460px;
    }

    #editProfileModalCreator .modal-content {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(59,91,219,0.15);
        font-family: 'Outfit', sans-serif;
    }

    /* ── Header ── */
    #editProfileModalCreator .modal-header {
        background: linear-gradient(135deg, #3B5BDB 0%, #4C6EF5 60%, #748FFC 100%);
        border: none;
        padding: 20px 26px 18px;
        position: relative;
        overflow: hidden;
    }

    #editProfileModalCreator .modal-header::after {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        top: -60px;
        right: -30px;
        pointer-events: none;
    }

    #editProfileModalCreator .modal-title {
        font-family: 'Lora', serif;
        font-size: 19px;
        font-weight: 600;
        color: #fff;
        letter-spacing: -0.2px;
        position: relative;
        z-index: 1;
    }

    #editProfileModalCreator .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.75;
        transition: opacity 0.2s, transform 0.2s;
        position: relative;
        z-index: 1;
    }

    #editProfileModalCreator .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* ── Body ── */
    #editProfileModalCreator .modal-body {
        background: #fff;
        padding: 26px 26px 6px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* ── Field ── */
    .vrc-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .vrc-label {
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        color: #3B5BDB;
    }

    .vrc-input,
    .vrc-textarea {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #DDEEFF;
        border-radius: 12px;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        color: #0F1E4A;
        background: #F5F8FF;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        resize: none;
    }

    .vrc-input::placeholder,
    .vrc-textarea::placeholder {
        color: #A0AECB;
    }

    .vrc-input:focus,
    .vrc-textarea:focus {
        border-color: #4C6EF5;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(76,110,245,0.12);
    }

    .vrc-textarea {
        min-height: 84px;
        line-height: 1.55;
    }

    /* ── Upload ── */
    .vrc-upload-label {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border: 1.5px dashed #BDC8F5;
        border-radius: 12px;
        background: #F5F8FF;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .vrc-upload-label:hover {
        border-color: #4C6EF5;
        background: #EEF2FF;
    }

    .vrc-upload-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(59,91,219,0.10);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #3B5BDB;
    }

    .vrc-upload-text strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #0F1E4A;
        margin-bottom: 1px;
    }

    .vrc-upload-text span {
        font-size: 11.5px;
        color: #7A8AB0;
    }

    #creator_photo_input { display: none; }

    .vrc-filename {
        display: none;
        font-size: 12px;
        color: #3B5BDB;
        font-weight: 500;
        margin-top: 5px;
    }

    /* ── Footer ── */
    #editProfileModalCreator .modal-footer {
        background: #fff;
        border: none;
        padding: 10px 26px 22px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-vrc-cancel {
        padding: 10px 20px;
        border-radius: 11px;
        font-family: 'Outfit', sans-serif;
        font-size: 13.5px;
        font-weight: 500;
        color: #7A8AB0;
        background: #EEF2FF;
        border: 1.5px solid #DDEEFF;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .btn-vrc-cancel:hover {
        background: #E0E7FF;
        color: #0F1E4A;
    }

    .btn-vrc-save {
        padding: 10px 24px;
        border-radius: 11px;
        font-family: 'Outfit', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #3B5BDB 0%, #4C6EF5 100%);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(59,91,219,0.35);
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-vrc-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(59,91,219,0.45);
    }

    .btn-vrc-save:active {
        transform: translateY(0);
    }
</style>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('creator.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="vrc-field">
                        <label class="vrc-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="vrc-input"
                               value="{{ auth()->user()->name }}"
                               placeholder="Nama lengkap"
                               required>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="vrc-field">
                        <label class="vrc-label">WhatsApp</label>
                        <input type="text"
                               name="whatsapp"
                               class="vrc-input"
                               value="{{ auth()->user()->whatsapp }}"
                               placeholder="Contoh: 08123456789">
                    </div>

                    {{-- Bio --}}
                    <div class="vrc-field">
                        <label class="vrc-label">Bio</label>
                        <textarea name="bio"
                                  class="vrc-textarea"
                                  placeholder="Ceritakan sedikit tentang dirimu…">{{ auth()->user()->bio }}</textarea>
                    </div>

                    {{-- Photo --}}
                    <div class="vrc-field">
                        <label class="vrc-label">Foto Profil</label>
                        <label class="vrc-upload-label" for="creator_photo_input">
                            <div class="vrc-upload-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <div class="vrc-upload-text">
                                <strong>Pilih foto baru</strong>
                                <span>JPG, PNG · Maks 2MB</span>
                            </div>
                        </label>
                        <input type="file" name="profile_photo" id="creator_photo_input" accept="image/*">
                        <p class="vrc-filename" id="vrc-upload-name"></p>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn-vrc-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-vrc-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
    document.getElementById('creator_photo_input').addEventListener('change', function () {
        const el = document.getElementById('vrc-upload-name');
        if (this.files && this.files[0]) {
            el.textContent = '📎 ' + this.files[0].name;
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    });
</script>