@extends('layouts.creator')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    Edit Template
                </div>

                <div class="card-body">
                    <form action="{{ route('creator.template.update', $template) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label">Judul Template</label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $template->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description', $template->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="mb-3">
                            <label class="form-label">Tipe Template</label>
                            <select name="type"
                                    id="templateType"
                                    class="form-control @error('type') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="video" {{ old('type', $template->type) == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="photo" {{ old('type', $template->type) == 'photo' ? 'selected' : '' }}>Photo</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $template->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Software --}}
                        <div class="mb-3">
                            <label class="form-label">Software</label>
                            <select name="software_id"
                                    class="form-control @error('software_id') is-invalid @enderror">
                                <option value="">-- Pilih Software --</option>
                                @foreach ($softwares as $software)
                                    <option value="{{ $software->id }}"
                                        {{ old('software_id', $template->software_id) == $software->id ? 'selected' : '' }}>
                                        {{ $software->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('software_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number"
                                   name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $template->price) }}"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- File --}}
                        <div class="mb-3">
                            <label class="form-label">Template File (optional)</label>
                            <input type="file"
                                   name="file"
                                   class="form-control @error('file') is-invalid @enderror">
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti file
                            </small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview --}}
                        <div class="mb-4">
                            <label class="form-label">Preview Image (optional)</label>

                            @if ($template->preview)
                                <div class="mb-2">
                                    <p class="text-muted small mb-1">Preview saat ini:</p>
                                    <img src="{{ asset('storage/' . $template->preview) }}"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                            @endif

                            <input type="file"
                                   name="preview"
                                   accept="image/*"
                                   class="form-control @error('preview') is-invalid @enderror">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti preview
                            </small>

                            @error('preview')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 {{ old('type', $template->type) === 'video' ? '' : 'd-none' }}" id="previewVideoWrapper">
                            <label class="form-label">Preview Video (optional)</label>

                            @if ($template->preview_video)
                                <div class="mb-2">
                                    <p class="text-muted small mb-1">Preview video saat ini:</p>
                                    <video controls style="max-width: 260px;" class="rounded border">
                                        <source src="{{ asset('storage/' . $template->preview_video) }}">
                                    </video>
                                </div>
                            @endif

                            <input type="file"
                                   name="preview_video"
                                   id="previewVideoInput"
                                   accept="video/mp4,video/webm,video/quicktime"
                                   class="form-control @error('preview_video') is-invalid @enderror">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti preview video.
                            </small>

                            @error('preview_video')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('creator.template.index') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button class="btn btn-primary">
                                Perbarui Template
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    (function () {
        const typeSelect = document.getElementById('templateType');
        const previewVideoWrapper = document.getElementById('previewVideoWrapper');
        const previewVideoInput = document.getElementById('previewVideoInput');

        function syncPreviewVideoField() {
            const isVideo = typeSelect.value === 'video';
            previewVideoWrapper.classList.toggle('d-none', !isVideo);
            previewVideoInput.required = false;

            if (!isVideo) {
                previewVideoInput.value = '';
            }
        }

        typeSelect.addEventListener('change', syncPreviewVideoField);
        syncPreviewVideoField();
    })();
</script>
@endsection
