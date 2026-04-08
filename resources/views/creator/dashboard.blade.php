@extends('layouts.creator')
@section('content')
<style>
    .avatar img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
    }
    .stats-icon {
        transition: 0.3s;
    }
    .stats-icon:hover {
        transform: scale(1.1);
    }
</style>
<div class="page-heading">
    <h3>Dashboard</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldCategory"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Templates</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalTemplates }}</h6>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card"> 
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldDownload"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Download</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalDownloads }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Sales</h6>
                                    <h6 class="font-extrabold mb-0">
                                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldStar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Rating</h6>
                                    <h6 class="font-extrabold mb-0">
                                        {{ number_format($averageRating ?? 0, 1) }} ⭐
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Your Templates</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Preview</th>
                                        <th>Judul</th>
                                        <th>Harga</th>
                                        <th>Downloads</th>
                                        <th>Terjual</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $template)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/'.$template->preview) }}"
                                                style="width:60px; border-radius:8px;">
                                        </td>
                                        <td>{{ $template->title }}</td>
                                        <td>
                                            {{ $template->price == 0 ? 'Gratis' : 'Rp '.number_format($template->price) }}
                                        </td>
                                        <td>{{ $template->download_count ?? 0 }}</td>
                                        <td>{{ $template->soldCount }}</td>
                                        <td>
                                            {{ number_format($template->average_rating ?? 0, 1) }} ⭐
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada template
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">

                    <div class="text-center">

                        <!-- Avatar -->
                        <div class="avatar avatar-xl mb-3">
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                style="object-fit: cover;">
                        </div>

                        <!-- Username -->
                        <h5 class="font-bold mb-1">
                            {{ Auth::user()->name }}
                        </h5>

                        <!-- Bio (limit) -->
                        <p class="text-muted mb-3">
                            {{ \Illuminate\Support\Str::limit(Auth::user()->bio, 60) }}
                        </p>

                        <!-- Button -->
                        <a href="{{ route('creator.profile.index') }}"
                        class="btn btn-outline-primary btn-sm w-100">
                            Edit Profile
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection