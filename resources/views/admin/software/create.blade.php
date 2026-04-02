@extends('layouts.creator')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    Create New Software
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.software.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="form-label">Software Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Adobe Premiere Pro"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.software.index') }}" class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button class="btn btn-primary">
                                Save Software
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection