@extends(auth()->user()->role === 'creator' ? 'layouts.creator' : 'layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    {{-- PHOTO --}}
                    <img src="{{ auth()->user()->profile_photo 
                        ? asset('storage/' . auth()->user()->profile_photo) 
                        : asset('assets/default-avatar.png') }}"
                        class="rounded-circle mb-3"
                        width="100"
                        height="100">

                    <h5 class="fw-bold">{{ auth()->user()->name }}</h5>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    <p>
                        {{ auth()->user()->bio ?? 'Belum ada bio' }}
                    </p>

                    <p>
                        <strong>WhatsApp:</strong>
                        {{ auth()->user()->whatsapp ?? '-' }}
                    </p>

                    <button class="btn btn-primary mt-2"
                            data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL --}}
@include('creator.profile.modal-edit')
@endsection
