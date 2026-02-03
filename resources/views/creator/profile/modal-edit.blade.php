<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('creator.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ auth()->user()->name }}"
                               required>
                    </div>

                    {{-- WHATSAPP --}}
                    <div class="mb-3">
                        <label class="form-label">WhatsApp</label>
                        <input type="text"
                               name="whatsapp"
                               class="form-control"
                               value="{{ auth()->user()->whatsapp }}">
                    </div>

                    {{-- BIO --}}
                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio"
                                  class="form-control"
                                  rows="3">{{ auth()->user()->bio }}</textarea>
                    </div>

                    {{-- PHOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Foto Profile</label>
                        <input type="file" name="profile_photo" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
