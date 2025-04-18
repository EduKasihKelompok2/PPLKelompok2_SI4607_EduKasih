@extends('layouts.app')
@section('title', 'Bank Soal')
@section('content')
<div class="container py-4">
    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Bank Soal</h1>
        <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm" data-bs-toggle="modal"
            data-bs-target="#addBankSoalModal">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Soal
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search and Filter Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bank-soal') }}" method="GET" id="filterForm">
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

                    <div class="btn-group w-100">
                        <button class="btn btn-success flex-fill view-btn" data-bs-toggle="modal"
                            data-bs-target="#detailBankSoalModal" data-id="{{ $bankSoal->id }}"
                            data-title="{{ $bankSoal->title }}" data-class="{{ $bankSoal->class }}"
                            data-subject="{{ $bankSoal->subject }}" data-description="{{ $bankSoal->description }}"
                            data-question-count="{{ $bankSoal->question_count }}"
                            data-upload-date="{{ $bankSoal->upload_date->format('Y-m-d') }}"
                            data-file-path="{{ Storage::url($bankSoal->file_path) }}">
                            <i class="bi bi-eye-fill me-1"></i> Lihat
                        </button>
                        <button class="btn btn-primary flex-fill edit-btn" data-bs-toggle="modal"
                            data-bs-target="#editBankSoalModal" data-id="{{ $bankSoal->id }}"
                            data-title="{{ $bankSoal->title }}" data-class="{{ $bankSoal->class }}"
                            data-subject="{{ $bankSoal->subject }}" data-description="{{ $bankSoal->description }}"
                            data-question-count="{{ $bankSoal->question_count }}"
                            data-upload-date="{{ $bankSoal->upload_date->format('Y-m-d') }}">
                            <i class="bi bi-pencil-fill me-1"></i> Edit
                        </button>
                        <button class="btn btn-danger flex-fill delete-btn" data-id="{{ $bankSoal->id }}"
                            data-title="{{ $bankSoal->title }}">
                            <i class="bi bi-trash-fill me-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                <h4>Tidak ada data bank soal</h4>
                <p class="mb-0">Silakan tambahkan bank soal baru dengan mengklik tombol "Tambah Soal".</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bankSoals->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Bank Soal Modal -->
<div class="modal fade" id="addBankSoalModal" tabindex="-1" aria-labelledby="addBankSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBankSoalModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>
                    Upload Bank Soal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.bank-soal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="judulSoal" class="form-label fw-bold">Judul Soal</label>
                        <input type="text" name="title" class="form-control form-control-lg" id="judulSoal"
                            placeholder="e.g., SOAL KELAS 12 - FISIKA - 3" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kelas" class="form-label fw-bold">Kelas</label>
                            <select class="form-select" id="kelas" name="class" required>
                                <option value="Kelas 12">Kelas 12</option>
                                <option value="Kelas 11">Kelas 11</option>
                                <option value="Kelas 10">Kelas 10</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="mataPelajaran" class="form-label fw-bold">Mata Pelajaran</label>
                            <select class="form-select" id="mataPelajaran" name="subject" required>
                                <option value="Fisika">Fisika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Geografi">Geografi</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosiologi">Sosiologi</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Upload</label>
                            <input type="date" class="form-control" id="tanggal" name="upload_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="questionCount" class="form-label fw-bold">Jumlah Soal</label>
                        <input type="number" class="form-control" id="questionCount" name="question_count" min="1"
                            value="1" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi (Optional)</label>
                        <textarea class="form-control" id="deskripsi" name="description" rows="2"
                            placeholder="Deskripsi singkat tentang soal"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">File Soal (PDF)</label>
                        <div class="dropzone-container border rounded-3 p-4 text-center position-relative">
                            <input type="file" name="file"
                                class="file-input position-absolute opacity-0 w-100 h-100 top-0 start-0"
                                style="cursor: pointer;" required accept=".pdf">
                            <div class="py-4">
                                <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                                <p class="text-muted mb-1">Drag and drop files here, or click to browse</p>
                                <p class="small text-muted">(Format: PDF. Max size: 10MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-lg btn-danger px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-lg btn-primary px-4">
                            <i class="bi bi-cloud-upload-fill me-2"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                        Lihat File PDF
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Bank Soal Modal -->
<div class="modal fade" id="editBankSoalModal" tabindex="-1" aria-labelledby="editBankSoalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editBankSoalModalLabel">
                    <i class="bi bi-pencil-fill me-2"></i>
                    Edit Bank Soal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editBankSoalForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editJudulSoal" class="form-label fw-bold">Judul Soal</label>
                        <input type="text" name="title" class="form-control form-control-lg" id="editJudulSoal"
                            required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="editKelas" class="form-label fw-bold">Kelas</label>
                            <select class="form-select" id="editKelas" name="class" required>
                                <option value="Kelas 12">Kelas 12</option>
                                <option value="Kelas 11">Kelas 11</option>
                                <option value="Kelas 10">Kelas 10</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="editMataPelajaran" class="form-label fw-bold">Mata Pelajaran</label>
                            <select class="form-select" id="editMataPelajaran" name="subject" required>
                                <option value="Fisika">Fisika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Geografi">Geografi</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosiologi">Sosiologi</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="editTanggal" class="form-label fw-bold">Tanggal Upload</label>
                            <input type="date" class="form-control" id="editTanggal" name="upload_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editQuestionCount" class="form-label fw-bold">Jumlah Soal</label>
                        <input type="number" class="form-control" id="editQuestionCount" name="question_count" min="1"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="editDeskripsi" class="form-label fw-bold">Deskripsi (Optional)</label>
                        <textarea class="form-control" id="editDeskripsi" name="description" rows="2"
                            placeholder="Deskripsi singkat tentang soal"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">File Soal (PDF) - Optional</label>
                        <div class="mb-1 small text-muted">Biarkan kosong jika tidak ingin mengubah file</div>
                        <div class="dropzone-container border rounded-3 p-4 text-center position-relative">
                            <input type="file" name="file"
                                class="file-input position-absolute opacity-0 w-100 h-100 top-0 start-0"
                                style="cursor: pointer;" accept=".pdf">
                            <div class="py-4">
                                <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                                <p class="text-muted mb-1">Drag and drop files here, or click to browse</p>
                                <p class="small text-muted">(Format: PDF. Max size: 10MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-lg btn-danger px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-lg btn-primary px-4">
                            <i class="bi bi-save-fill me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBankSoalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-exclamation-circle text-danger" style="font-size: 5rem;"></i>
                <h4 class="mt-3 mb-3">Apakah Anda yakin ingin menghapus?</h4>
                <p id="delete-title" class="mb-0 fw-bold"></p>
                <p class="text-muted mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <form id="deleteBankSoalForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                </form>
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

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    .dropzone-container {
        border: 2px dashed #dee2e6 !important;
        transition: all 0.2s ease;
    }

    .dropzone-container:hover {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.05);
    }

    /* Filename display for file input */
    .file-name {
        margin-top: 10px;
        font-weight: 500;
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

        // Show filename for file inputs
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const parent = this.closest('.dropzone-container');
                let existingNameElem = parent.querySelector('.file-name');

                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    if (existingNameElem) {
                        existingNameElem.textContent = fileName;
                    } else {
                        const nameElem = document.createElement('div');
                        nameElem.className = 'file-name';
                        nameElem.textContent = fileName;
                        parent.appendChild(nameElem);
                    }
                } else if (existingNameElem) {
                    existingNameElem.remove();
                }
            });
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

        // Edit button click handler
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const kelas = this.getAttribute('data-class');
                const subject = this.getAttribute('data-subject');
                const description = this.getAttribute('data-description') || '';
                const questionCount = this.getAttribute('data-question-count');
                const uploadDate = this.getAttribute('data-upload-date');

                // Set form action
                document.getElementById('editBankSoalForm').action = `/admin/bank-soal/${id}`;

                // Set form data
                document.getElementById('editJudulSoal').value = title;
                document.getElementById('editKelas').value = kelas;
                document.getElementById('editMataPelajaran').value = subject;
                document.getElementById('editQuestionCount').value = questionCount;
                document.getElementById('editTanggal').value = uploadDate;
                document.getElementById('editDeskripsi').value = description;
            });
        });

        // Delete button click handler
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteBankSoalModal'));

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');

                // Set delete form action
                document.getElementById('deleteBankSoalForm').action = `/admin/bank-soal/${id}`;

                // Set modal content
                document.getElementById('delete-title').textContent = title;

                // Show modal
                deleteModal.show();
            });
        });
    });
</script>
@endpush
@endsection