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
            <!-- Admin Add Course Button -->
            <a href="{{ route('admin.e-course.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Tambah E-Course Baru
            </a>
        </div>
        <div class="col-lg-6">
            <!-- Search Bar -->
            <div class="mt-3 mt-lg-0">
                <form action="{{ route('admin.e-course') }}" method="GET">
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
            <a href="{{ route('admin.e-course') }}"
                class="btn {{ !request()->has('kategori') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua Kategori
            </a>
            @php
            $categories = [
            'Fisika', 'Kimia', 'Matematika', 'Biologi', 'Bahasa Inggris',
            'Bahasa Indonesia', 'Sejarah', 'Geografi', 'Ekonomi', 'Sosiologi'
            ];
            @endphp

            @foreach($categories as $category)
            <a href="{{ route('admin.e-course', ['kategori' => strtolower($category), 'query' => request('query')]) }}"
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
            <div class="card h-100 shadow-sm course-card">
                <img src="{{ asset($course['image']) }}" class="card-img-top" alt="{{ $course['title'] }}">
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-star-fill"></i> {{ $course->rating }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $course['title'] }}</h5>
                    <p class="card-subtitle text-muted mb-3">{{ $course['subject'] }}</p>
                    <div class="card-text"
                        style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; max-height: 3rem;">
                        {!! $course['description'] !!}
                    </div>
                    <!-- Admin controls -->
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{route('admin.e-course.show', $course['id'])}}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                        <div class="btn-group">
                            <a href="{{route('admin.e-course.edit', $course['id'])}}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteCourseModal" data-course-id="{{ $course['id'] }}"
                                data-course-title="{{ $course['course_name'] }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <h4 class="mt-3">Maaf, materi yang Anda cari tidak ditemukan.</h4>
                <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori yang tersedia.</p>
                <a href="{{ route('admin.e-course') }}" class="btn btn-primary mt-2">
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCourseModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus e-course "<span id="courseTitle"></span>"?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteCourseForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete course modal handler
        const deleteModal = document.getElementById('deleteCourseModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const courseId = button.getAttribute('data-course-id');
                const courseTitle = button.getAttribute('data-course-title');

                const form = document.getElementById('deleteCourseForm');
                form.action = `/admin/e-course/${courseId}`;

                const titleElement = document.getElementById('courseTitle');
                titleElement.textContent = courseTitle;
            });
        }
    });
</script>
@endpush