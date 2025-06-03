@extends('layouts.app')
@section('title', 'E-Course')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <h1 class="fw-bold">E-Course</h1>
            <p class="text-muted">
                Jelajahi berbagai e-course terbaik yang dirancang untuk membantu
                siswa SMA memahami konsep dengan lebih mudah dan menyenangkan.
                Dari Matematika hingga Bahasa, temukan materi yang sesuai dengan
                kebutuhan belajar Anda dan tingkatkan prestasi akademik Anda!
            </p>
        </div>
        <div class="col-lg-6">
            <!-- Search Bar -->
            <div class="mt-3 mt-lg-0">
                <form action="{{ route('e-course') }}" method="GET">
                    <!-- Preserve category filter when searching -->
                    @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari materi pelajaran..." name="query"
                            value="{{ request('query') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('e-course') }}"
                class="btn {{ request()->is('e-course') && !request()->has('kategori') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua Kategori
            </a>
            @php
            $categories = [
            'Fisika', 'Kimia', 'Matematika', 'Biologi', 'Bahasa Inggris',
            'Bahasa Indonesia', 'Sejarah', 'Geografi', 'Ekonomi', 'Sosiologi'
            ];
            @endphp

            @foreach($categories as $category)
            <a href="{{ route('e-course', ['kategori' => strtolower($category), 'query' => request('query')]) }}"
                class="btn {{ request('kategori') == strtolower($category) ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ $category }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Content Cards -->
    <div class="row g-4">
        @if($courses->count() > 0)
        @foreach($courses as $course)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('e-course.show', $course->id) }}" class="card-link text-decoration-none text-dark">
                <div class="card h-100 shadow-sm course-card">
                    <img src="{{ $course->image ?? 'https://source.unsplash.com/random/600x400/?education' }}"
                        class="card-img-top" alt="{{ $course->course_name }}">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-star-fill"></i> {{ $course->rating }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->course_name }}</h5>
                        <p class="card-subtitle text-muted mb-3">{{ $course->nama_mapel }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-collection-play me-1"></i> {{ $course->getTotalVideos() }} Video
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i> {{ $course->getTotalDuration() }} Menit
                            </small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @else
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <h4 class="mt-3">Maaf, materi yang Anda cari tidak ditemukan.</h4>
                <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori yang tersedia.</p>
                <a href="{{ route('e-course') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke semua materi
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($courses->total() > $courses->perPage())
    <div class="d-flex justify-content-center mt-5">
        {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .btn-outline-secondary {
        border-color: #e9ecef;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #212529;
    }

    .course-card {
        transition: all 0.3s ease;
    }

    .course-card:hover {
        background-color: #E8F6FF;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .card-link {
        display: block;
        height: 100%;
    }
</style>
@endpush