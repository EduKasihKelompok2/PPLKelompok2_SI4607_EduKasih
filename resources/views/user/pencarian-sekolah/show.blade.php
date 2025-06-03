@extends('layouts.app')
@section('title', $school->name)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .banner-container {
        height: 400px;
        overflow: hidden;
        position: relative;
    }

    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.6));
        display: flex;
        align-items: flex-end;
        padding: 2rem;
    }

    .banner-overlay h1 {
        color: white;
        margin-bottom: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
    }

    .info-box {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
    }

    .section-title {
        position: relative;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 50px;
        background-color: #6366F1;
    }
</style>
@endpush

@section('content')
<div class="banner-container mb-4">
    @if($school->image)
    <img src="{{ Storage::url($school->image) }}" alt="{{ $school->name }}" class="banner-image">
    @else
    <div class="bg-dark banner-image"></div>
    @endif
    <div class="banner-overlay">
        <h1>{{ $school->name }}</h1>
    </div>
</div>

<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('pencarian-sekolah') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- School Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <span class="badge bg-primary me-2">{{ $school->type }}</span>
                        <span class="badge bg-light text-dark">Terakreditasi {{ $school->accreditation }}</span>
                        <span class="ms-auto text-muted small">
                            Berdiri sejak {{ $school->founded_year }}
                        </span>
                    </div>

                    <h3 class="section-title">Tentang</h3>
                    <p>{!! $school->description !!}</p>

                    <!-- Faculty Information -->
                    @if($school->faculties->count() > 0)
                    <h3 class="section-title">Fakultas & Program Studi</h3>
                    <div class="row">
                        @foreach($school->faculties as $faculty)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $faculty->name }}</h5>
                                    {!!$faculty->programs!!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body info-box">
                    <h5 class="card-title section-title">Informasi Perguruan Tinggi</h5>

                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <strong>Lokasi:</strong>
                        <p class="ms-4 mb-0">{{ $school->address ?? $school->city . ', ' . $school->province }}</p>
                    </div>

                    <div class="mb-3">
                        <i class="fas fa-user-graduate text-primary me-2"></i>
                        <strong>Jumlah Mahasiswa:</strong>
                        <p class="ms-4 mb-0">{{ $school->students }}</p>
                    </div>

                    <div class="mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong>Status:</strong>
                        <p class="ms-4 mb-0">{{ $school->status }}</p>
                    </div>

                    <hr>

                    <h5 class="card-title section-title">Informasi Kontak</h5>

                    @if($school->website)
                    <div class="mb-3">
                        <i class="fas fa-globe text-primary me-2"></i>
                        <strong>Website:</strong>
                        <p class="ms-4 mb-0">
                            <a href="{{ $school->website }}" target="_blank" class="text-decoration-none">
                                {{ $school->website }} <i class="fas fa-external-link-alt small"></i>
                            </a>
                        </p>
                    </div>
                    @endif

                    @if($school->instagram)
                    <div class="mb-3">
                        <i class="fab fa-instagram text-primary me-2"></i>
                        <strong>Instagram:</strong>
                        <p class="ms-4 mb-0">
                            <a href="https://instagram.com/{{ str_replace('@', '', $school->instagram) }}"
                                target="_blank" class="text-decoration-none">
                                {{ $school->instagram }}
                            </a>
                        </p>
                    </div>
                    @endif

                    @if($school->contact)
                    <div class="mb-3">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <strong>Telepon:</strong>
                        <p class="ms-4 mb-0">
                            <a href="tel:{{ $school->contact }}" class="text-decoration-none">
                                {{ $school->contact }}
                            </a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection