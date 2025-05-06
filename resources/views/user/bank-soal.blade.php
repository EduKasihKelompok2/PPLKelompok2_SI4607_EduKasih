@extends('layouts.app')
@section('title', 'Bank Soal')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Bank Soal</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search and Filter Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('bank-soal') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0"
                                placeholder="Cari soal..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="class">
                            <option value="Semua Kelas" {{ request('class')=='Semua Kelas' ? 'selected' : '' }}>Semua
                                Kelas</option>
                            <option value="Kelas 10" {{ request('class')=='Kelas 10' ? 'selected' : '' }}>Kelas 10
                            </option>
                            <option value="Kelas 11" {{ request('class')=='Kelas 11' ? 'selected' : '' }}>Kelas 11
                            </option>
                            <option value="Kelas 12" {{ request('class')=='Kelas 12' ? 'selected' : '' }}>Kelas 12
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="subject">
                            <option value="Semua Mata Pelajaran" {{ request('subject')=='Semua Mata Pelajaran'
                                ? 'selected' : '' }}>Semua Mata Pelajaran</option>
                            <option value="Fisika" {{ request('subject')=='Fisika' ? 'selected' : '' }}>Fisika</option>
                            <option value="Kimia" {{ request('subject')=='Kimia' ? 'selected' : '' }}>Kimia</option>
                            <option value="Matematika" {{ request('subject')=='Matematika' ? 'selected' : '' }}>
                                Matematika</option>
                            <option value="Biologi" {{ request('subject')=='Biologi' ? 'selected' : '' }}>Biologi
                            </option>
                            <option value="Bahasa Inggris" {{ request('subject')=='Bahasa Inggris' ? 'selected' : '' }}>
                                Bahasa Inggris</option>
                            <option value="Bahasa Indonesia" {{ request('subject')=='Bahasa Indonesia' ? 'selected' : ''
                                }}>Bahasa Indonesia</option>
                            <option value="Sejarah" {{ request('subject')=='Sejarah' ? 'selected' : '' }}>Sejarah
                            </option>
                            <option value="Geografi" {{ request('subject')=='Geografi' ? 'selected' : '' }}>Geografi
                            </option>
                            <option value="Ekonomi" {{ request('subject')=='Ekonomi' ? 'selected' : '' }}>Ekonomi
                            </option>
                            <option value="Sosiologi" {{ request('subject')=='Sosiologi' ? 'selected' : '' }}>Sosiologi
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Question Bank Cards -->
    <div class="row g-4">
        @forelse($bankSoals as $bankSoal)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title fw-bold mb-3">{{ $bankSoal->title }}</h5>
                        <span class="text-{{ $bankSoal->badge_color }}">{{ $bankSoal->subject }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center text-muted mb-3">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        <span>{{ $bankSoal->question_count }} Soal</span>
                        <i class="bi bi-calendar3 ms-3 me-2"></i>
                        <span>Update: {{ $bankSoal->upload_date->format('d M Y') }}</span>
                    </div>

                    <p class="card-text text-muted mb-4">{{ $bankSoal->description ?? 'Kumpulan soal untuk persiapan
                        ujian.' }}</p>

                    <button class="btn btn-success w-100 view-btn" data-bs-toggle="modal"
                        data-bs-target="#detailBankSoalModal" data-id="{{ $bankSoal->id }}"
                        data-title="{{ $bankSoal->title }}" data-class="{{ $bankSoal->class }}"
                        data-subject="{{ $bankSoal->subject }}" data-description="{{ $bankSoal->description }}"
                        data-question-count="{{ $bankSoal->question_count }}"
                        data-upload-date="{{ $bankSoal->upload_date->format('Y-m-d') }}"
                        data-file-path="{{ Storage::url($bankSoal->file_path) }}">
                        <i class="bi bi-eye-fill me-1"></i> Lihat & Download
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                <h4>Tidak ada data bank soal</h4>
                <p class="mb-0">Bank soal saat ini tidak tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bankSoals->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Detail Bank Soal Modal -->
<div class="modal fade" id="detailBankSoalModal" tabindex="-1" aria-labelledby="detailBankSoalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="detailBankSoalModalLabel">
                    <i class="bi bi-eye-fill me-2"></i>
                    Detail Bank Soal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h3 id="detail-title" class="mb-4 fw-bold"></h3>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Kelas</h6>
                            <p id="detail-class" class="fs-5 fw-semibold"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Mata Pelajaran</h6>
                            <p id="detail-subject" class="fs-5 fw-semibold"></p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Jumlah Soal</h6>
                            <p id="detail-question-count" class="fs-5 fw-semibold"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Tanggal Upload</h6>
                            <p id="detail-upload-date" class="fs-5 fw-semibold"></p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted mb-1">Deskripsi</h6>
                    <p id="detail-description" class="fs-6"></p>
                </div>

                <div class="mb-4 text-center">
                    <a id="detail-file-link" href="#" class="btn btn-lg btn-primary" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i>
                        Lihat & Download PDF
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Style for pagination */
    .pagination {
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-active-border-color: #0d6efd;
    }

    /* Add new custom badge colors for additional subjects */
    .bg-indigo {
        background-color: #6610f2 !important;
        color: white !important;
    }

    .bg-purple {
        background-color: #6f42c1 !important;
        color: white !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // View button click handler
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const kelas = this.getAttribute('data-class');
                const subject = this.getAttribute('data-subject');
                const description = this.getAttribute('data-description') || 'Tidak ada deskripsi.';
                const questionCount = this.getAttribute('data-question-count');
                const uploadDate = this.getAttribute('data-upload-date');
                const filePath = this.getAttribute('data-file-path');

                // Format date
                const formattedDate = new Date(uploadDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Set modal data
                document.getElementById('detail-title').textContent = title;
                document.getElementById('detail-class').textContent = kelas;
                document.getElementById('detail-subject').textContent = subject;
                document.getElementById('detail-question-count').textContent = questionCount + ' Soal';
                document.getElementById('detail-upload-date').textContent = formattedDate;
                document.getElementById('detail-description').textContent = description;
                document.getElementById('detail-file-link').href = filePath;
            });
        });
    });
</script>
@endpush
@endsection