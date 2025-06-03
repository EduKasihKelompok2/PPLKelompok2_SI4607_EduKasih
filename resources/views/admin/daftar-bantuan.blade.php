@extends('layouts.app')
@section('title', 'Daftar Bantuan Beasiswa')

@section('content')
<!-- Main Content -->
<div class="bg-light min-vh-100">
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h2 fw-bold text-dark mb-2">Daftar Bantuan</h2>
                <p class="text-muted">Informasi beasiswa dan bantuan pendidikan yang tersedia untuk mahasiswa</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                    data-bs-target="#scholarshipFormModal">
                    Tambah Beasiswa
                </button>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="mb-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <input type="text" id="searchInput" placeholder="Cari beasiswa..."
                                class="form-control form-control-lg" autocomplete="off">
                        </div>
                        <button class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20"
                                height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scholarships Grid -->
        <div class="row g-3" id="scholarshipsContainer">
            @forelse($scholarships as $scholarship)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 scholarship-card">
                    <div class="position-relative">
                        @if($scholarship->thumbnail)
                        <img src="{{ asset('storage/' . $scholarship->thumbnail) }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;" alt="{{ $scholarship->name }}">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <svg class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="64"
                                height="64">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-2">
                            @php
                            $now = now();
                            $isActive = $scholarship->registration_start <= $now && $scholarship->registration_end >=
                                $now;
                                @endphp
                                <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                    {{ $isActive ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h5 fw-bold text-dark mb-3">{{ $scholarship->name }}</h3>
                        <div class="d-flex align-items-center text-muted mb-3">
                            <svg class="text-primary me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <small>Tanggal pendaftaran : {{ $scholarship->formatted_registration_start }} - {{
                                $scholarship->formatted_registration_end }}</small>
                        </div>
                        <p class="text-muted small mb-3 lh-base">
                            {{ Str::limit($scholarship->description, 150) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-info text-white"
                                    onclick="viewScholarship({{ $scholarship->id }})">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Detail
                                </button>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary"
                                    onclick="editScholarship({{ $scholarship->id }})"
                                    data-name="{{ $scholarship->name }}"
                                    data-registration_start="{{ $scholarship->registration_start->format('Y-m-d') }}"
                                    data-registration_end="{{ $scholarship->registration_end->format('Y-m-d') }}"
                                    data-description="{{ $scholarship->description }}">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="deleteScholarship({{ $scholarship->id }}, '{{ $scholarship->name }}')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="alert alert-info d-inline-block">
                        <svg class="text-info mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48"
                            height="48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <p class="fw-medium mb-0">Belum ada data beasiswa</p>
                        <small class="text-muted">Klik tombol "Tambah Beasiswa" untuk menambahkan data baru</small>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5 d-none">
            <div class="alert alert-info d-inline-block">
                <svg class="text-info mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48"
                    height="48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="fw-medium mb-0">Tidak ada hasil yang ditemukan</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Scholarship -->
<div class="modal fade" id="scholarshipFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="scholarshipFormModalLabel">Tambah Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="scholarshipForm" method="POST" action="{{ route('admin.scholarships.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Beasiswa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registration_start" class="form-label">Tanggal Mulai Pendaftaran <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="registration_start"
                                    name="registration_start" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registration_end" class="form-label">Tanggal Akhir Pendaftaran <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="registration_end" name="registration_end"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus beasiswa <strong id="deleteScholarshipName"></strong>?</p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Scholarship Detail -->
<div class="modal fade" id="scholarshipDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="scholarshipDetailContent">
                <!-- Detail content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Scholarship Detail -->
<div class="modal fade" id="scholarshipModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Modal content will be inserted here -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .scholarship-card {
        transition: all 0.3s ease;
    }

    .scholarship-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Function to view scholarship detail
function viewScholarship(id) {
    fetch(`/admin/scholarships/${id}`)
        .then(response => response.json())
        .then(data => {
            const scholarship = data.scholarship;
            const content = `
                <div class="row">
                    <div class="col-md-4">
                        ${scholarship.thumbnail
                            ? `<img src="/storage/${scholarship.thumbnail}" class="img-fluid rounded" alt="${scholarship.name}">`
                            : `<div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                 <svg class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="64" height="64">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                 </svg>
                               </div>`
                        }
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-3">${scholarship.name}</h4>
                        <div class="mb-3">
                            <h6 class="text-muted">Status</h6>
                            <span class="badge ${scholarship.is_active ? 'bg-success' : 'bg-secondary'} rounded-pill">
                                ${scholarship.is_active ? 'Aktif' : 'Tidak Aktif'}
                            </span>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted">Periode Pendaftaran</h6>
                            <p class="mb-0">${scholarship.formatted_registration_start} - ${scholarship.formatted_registration_end}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted">Deskripsi</h6>
                            <p class="mb-0">${scholarship.description}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted">Dibuat pada</h6>
                            <p class="mb-0">${scholarship.created_at}</p>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('scholarshipDetailContent').innerHTML = content;
            const modal = new bootstrap.Modal(document.getElementById('scholarshipDetailModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail beasiswa');
        });
}

// Edit and Delete functions
function editScholarship(id) {
    const button = event.target.closest('button');
    const name = button.getAttribute('data-name');
    const registrationStart = button.getAttribute('data-registration_start');
    const registrationEnd = button.getAttribute('data-registration_end');
    const description = button.getAttribute('data-description');

    // Set modal title and form action
    document.getElementById('scholarshipFormModalLabel').textContent = 'Edit Beasiswa';
    document.getElementById('scholarshipForm').action = `/admin/scholarships/${id}`;
    document.getElementById('submitBtn').textContent = 'Update';

    // Add method spoofing for PUT request
    let methodInput = document.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('scholarshipForm').appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    // Fill form with existing data
    document.getElementById('name').value = name;
    document.getElementById('registration_start').value = registrationStart;
    document.getElementById('registration_end').value = registrationEnd;
    document.getElementById('description').value = description;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('scholarshipFormModal'));
    modal.show();
}

function deleteScholarship(id, name) {
    // Set delete form action and scholarship name
    document.getElementById('deleteForm').action = `/admin/scholarships/${id}`;
    document.getElementById('deleteScholarshipName').textContent = name;

    // Show delete modal
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Reset form when modal is hidden
document.getElementById('scholarshipFormModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('scholarshipFormModalLabel').textContent = 'Tambah Beasiswa';
    document.getElementById('scholarshipForm').action = '{{ route("admin.scholarships.store") }}';
    document.getElementById('submitBtn').textContent = 'Simpan';
    document.getElementById('scholarshipForm').reset();

    // Remove method input if exists
    const methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
});

// Search functionality for real data
function searchScholarships() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.scholarship-card').parentNode;
    let visibleCount = 0;

    document.querySelectorAll('[id^="scholarshipsContainer"] .col-md-6').forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('p').textContent.toLowerCase();

        if (name.includes(query) || description.includes(query)) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    const noResults = document.getElementById('noResults');
    if (visibleCount === 0 && query !== '') {
        noResults.classList.remove('d-none');
    } else {
        noResults.classList.add('d-none');
    }
}

// Initialize functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', searchScholarships);
});
</script>
@endpush