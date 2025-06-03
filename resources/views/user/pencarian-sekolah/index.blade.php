@extends('layouts.app')
@section('title', 'Pencarian Sekolah')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card-school {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
    }

    .card-school:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        height: 180px;
        object-fit: cover;
    }

    .card-school .badge {
        font-size: 0.8rem;
    }

    .page-header {
        background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Pencarian Sekolah</h1>
        <p class="lead">Temukan perguruan tinggi terbaik yang sesuai dengan minat dan bakatmu</p>
    </div>
</div>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('pencarian-sekolah') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari perguruan tinggi..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($schools as $school)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-school shadow-sm h-100">
                @if($school->image)
                <img src="{{ Storage::url($school->image) }}" class="card-img-top" alt="{{ $school->name }}">
                @else
                <div class="bg-secondary card-img-top"></div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $school->name }}</h5>
                        <span class="badge bg-primary">{{ $school->type }}</span>
                    </div>
                    <p class="card-text text-muted small">
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $school->city }}, {{ $school->province }}
                    </p>
                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($school->description), 120) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-dark">Akreditasi {{ $school->accreditation }}</span>
                        <a href="{{ route('pencarian-sekolah.show', $school) }}"
                            class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Tidak ada perguruan tinggi yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection