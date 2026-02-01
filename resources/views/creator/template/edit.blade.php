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
                    <form action="{{ route('creator.template.update', $template->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label">Template Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $template->title) }}"
                                   placeholder="Contoh: Preset Cinematic Orange"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Jelaskan detail template..."
                                      required>{{ old('description', $template->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label class="form-label">Price (Rp)</label>
                            <input type="number"
                                   name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $template->price) }}"
                                   placeholder="0 untuk Free"
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

                            {{-- Preview Lama --}}
                            @if ($template->preview)
                                <div class="mb-2">
                                    <p class="text-muted small mb-1">Preview saat ini:</p>
                                    <img src="{{ asset('storage/' . $template->preview) }}"
                                        alt="Preview Template"
                                        class="img-thumbnail"
                                        style="max-width: 200px;">
                                </div>
                            @endif

                            {{-- Input --}}
                            <input type="file"
                                name="preview"
                                class="form-control @error('preview') is-invalid @enderror">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti preview
                            </small>

                            @error('preview')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Button --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('creator.template.index') }}" class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button class="btn btn-primary">
                                Update Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
