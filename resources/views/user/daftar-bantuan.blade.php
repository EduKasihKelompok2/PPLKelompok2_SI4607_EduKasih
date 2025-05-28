@extends('layouts.app')
@section('title', 'Daftar Bantuan Beasiswa')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">Daftar Bantuan</h1>
            <p class="text-muted">Informasi beasiswa dan bantuan pendidikan yang tersedia untuk mahasiswa</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari beasiswa..."
                            autocomplete="off">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-outline-primary active" data-filter="all">Semua</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="active">Periode Aktif</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="academic">Akademik</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="financial">Finansial</button>
            </div>
        </div>
    </div>

    <div class="row" id="scholarshipsContainer">
        <!-- Beasiswa 1 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="/api/placeholder/800/400" class="card-img-top" height="200" alt="Beasiswa 1">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="card-title">BEASISWA 1</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span>17 Agustus 2025 - 15 September 2025</span>
                        </div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="badge bg-light text-dark me-1">Sarjana</span>
                                <span class="badge bg-light text-dark">Full Coverage</span>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(1)">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Scholarship 2 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="/api/placeholder/800/400" class="card-img-top" height="200" alt="Beasiswa 2">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="card-title">BEASISWA 2</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span>25 Agustus 2025 - 6 September 2025</span>
                        </div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="badge bg-light text-dark me-1">Pascasarjana</span>
                                <span class="badge bg-light text-dark">Partial</span>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(2)">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scholarship 3 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="/api/placeholder/800/400" class="card-img-top" height="200" alt="Beasiswa 3">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-secondary">Akan Datang</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="card-title">BEASISWA PRESTASI</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span>10 Oktober 2025 - 30 Oktober 2025</span>
                        </div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="badge bg-light text-dark me-1">Sarjana</span>
                                <span class="badge bg-light text-dark">Prestasi</span>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(3)">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scholarship 4 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="/api/placeholder/800/400" class="card-img-top" height="200" alt="Beasiswa 4">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">Ditutup</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="card-title">BEASISWA RISET</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span>10 Juli 2025 - 10 Agustus 2025</span>
                        </div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="badge bg-light text-dark me-1">Pascasarjana</span>
                                <span class="badge bg-light text-dark">Riset</span>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(4)">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="col-12 text-center py-5 d-none">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Tidak ada hasil yang ditemukan
        </div>
    </div>
</div>

<!-- Scholarship Detail Modal -->
<div class="modal fade" id="scholarshipDetailModal" tabindex="-1" aria-labelledby="scholarshipDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Modal content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #6366F1;
        border-color: #6366F1;
    }

    .btn-primary:hover {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }

    .btn-outline-primary {
        color: #6366F1;
        border-color: #6366F1;
    }

    .btn-outline-primary:hover {
        background-color: #6366F1;
        border-color: #6366F1;
    }

    .text-primary {
        color: #6366F1 !important;
    }

    .bg-primary {
        background-color: #6366F1 !important;
    }

    .modal-xl {
        max-width: 90%;
    }

    @media (max-width: 992px) {
        .modal-xl {
            max-width: 95%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Dummy scholarship data
    const scholarships = [
        {
            id: 1,
            name: "BEASISWA 1",
            status: "Aktif",
            category: "academic",
            startDate: "17 Agustus 2025",
            endDate: "15 September 2025",
            level: "Sarjana",
            coverage: "Full Coverage",
            provider: "Kementerian Pendidikan dan Kebudayaan",
            fundingAmount: "Rp 12.000.000 / semester",
            image: "/api/placeholder/800/400", // Placeholder image
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            requirements: [
                "Warga Negara Indonesia",
                "IPK minimal 3.00",
                "Aktif sebagai mahasiswa",
                "Tidak sedang menerima beasiswa lain",
                "Memiliki prestasi akademik atau non-akademik"
            ],
            benefits: [
                "Biaya kuliah penuh",
                "Tunjangan biaya hidup",
                "Tunjangan buku",
                "Asuransi kesehatan"
            ],
            documents: [
                "Surat permohonan",
                "CV terbaru",
                "Transkrip nilai",
                "Surat rekomendasi",
                "Sertifikat prestasi (jika ada)"
            ],
            contact: {
                email: "beasiswa1@kemendikbud.go.id",
                phone: "021-5703303",
                website: "https://www.kemendikbud.go.id"
            }
        },
        {
            id: 2,
            name: "BEASISWA 2",
            status: "Aktif",
            category: "financial",
            startDate: "25 Agustus 2025",
            endDate: "6 September 2025",
            level: "Pascasarjana",
            coverage: "Partial",
            provider: "Bank Indonesia",
            fundingAmount: "Rp 10.000.000 / semester",
            image: "/api/placeholder/800/400", // Placeholder image
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            requirements: [
                "Warga Negara Indonesia",
                "IPK minimal 3.25",
                "Mahasiswa program pascasarjana",
                "Usia maksimal 35 tahun",
                "Jurusan Ekonomi, Keuangan, atau Perbankan"
            ],
            benefits: [
                "Biaya kuliah sebagian",
                "Tunjangan penelitian",
                "Kesempatan magang di Bank Indonesia",
                "Jaringan alumni"
            ],
            documents: [
                "Surat permohonan",
                "CV terbaru",
                "Transkrip nilai",
                "Proposal penelitian",
                "Surat rekomendasi dari dosen"
            ],
            contact: {
                email: "beasiswa@bi.go.id",
                phone: "021-2981800",
                website: "https://www.bi.go.id"
            }
        },
        {
            id: 3,
            name: "BEASISWA PRESTASI",
            status: "Akan Datang",
            category: "academic",
            startDate: "10 Oktober 2025",
            endDate: "30 Oktober 2025",
            level: "Sarjana",
            coverage: "Prestasi",
            provider: "Universitas Indonesia",
            fundingAmount: "Rp 8.000.000 / semester",
            image: "/api/placeholder/800/400", // Placeholder image
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            requirements: [
                "Mahasiswa aktif Universitas Indonesia",
                "IPK minimal 3.50",
                "Memiliki prestasi akademik atau non-akademik tingkat nasional/internasional",
                "Aktif dalam kegiatan organisasi",
                "Tidak sedang menerima beasiswa lain"
            ],
            benefits: [
                "Pembebasan biaya kuliah",
                "Tunjangan bulanan",
                "Prioritas pertukaran pelajar",
                "Pendampingan karir"
            ],
            documents: [
                "Formulir pendaftaran",
                "CV terbaru",
                "Transkrip nilai",
                "Fotokopi sertifikat prestasi",
                "Esai motivasi"
            ],
            contact: {
                email: "beasiswa@ui.ac.id",
                phone: "021-7867222",
                website: "https://www.ui.ac.id"
            }
        },
        {
            id: 4,
            name: "BEASISWA RISET",
            status: "Ditutup",
            category: "academic",
            startDate: "10 Juli 2025",
            endDate: "10 Agustus 2025",
            level: "Pascasarjana",
            coverage: "Riset",
            provider: "LPDP",
            fundingAmount: "Rp 15.000.000 / semester",
            image: "/api/placeholder/800/400", // Placeholder image
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            requirements: [
                "Warga Negara Indonesia",
                "IPK minimal 3.50",
                "Mahasiswa program S2/S3",
                "Memiliki proposal penelitian inovatif",
                "Bidang penelitian sesuai prioritas nasional"
            ],
            benefits: [
                "Dana penelitian",
                "Biaya publikasi",
                "Kesempatan konferensi internasional",
                "Akses laboratorium riset"
            ],
            documents: [
                "Proposal penelitian",
                "CV terbaru",
                "Transkrip nilai",
                "Surat rekomendasi",
                "Rencana anggaran penelitian"
            ],
            contact: {
                email: "riset@lpdp.go.id",
                phone: "021-5151051",
                website: "https://www.lpdp.kemenkeu.go.id"
            }
        }
    ];

    // Function to display scholarship detail in modal
    function showScholarshipDetail(scholarshipId) {
        const scholarship = scholarships.find(s => s.id === scholarshipId);
        if (!scholarship) return;

        // Generate requirements HTML
        let requirementsHtml = '';
        if (scholarship.requirements && scholarship.requirements.length > 0) {
            requirementsHtml = `
                <div class="mt-4">
                    <h5><i class="fas fa-clipboard-list text-primary me-2"></i>Persyaratan</h5>
                    <ul class="ps-3">
                        ${scholarship.requirements.map(req => `<li>${req}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        // Generate benefits HTML
        let benefitsHtml = '';
        if (scholarship.benefits && scholarship.benefits.length > 0) {
            benefitsHtml = `
                <div class="mt-4">
                    <h5><i class="fas fa-gift text-primary me-2"></i>Manfaat</h5>
                    <ul class="ps-3">
                        ${scholarship.benefits.map(benefit => `<li>${benefit}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        // Generate documents HTML
        let documentsHtml = '';
        if (scholarship.documents && scholarship.documents.length > 0) {
            documentsHtml = `
                <div class="mt-4">
                    <h5><i class="fas fa-file-alt text-primary me-2"></i>Dokumen yang Diperlukan</h5>
                    <ul class="ps-3">
                        ${scholarship.documents.map(doc => `<li>${doc}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        // Generate status badge HTML
        let statusBadge = '';
        if (scholarship.status === 'Aktif') {
            statusBadge = '<span class="badge bg-success me-2">Aktif</span>';
        } else if (scholarship.status === 'Ditutup') {
            statusBadge = '<span class="badge bg-danger me-2">Ditutup</span>';
        } else if (scholarship.status === 'Akan Datang') {
            statusBadge = '<span class="badge bg-secondary me-2">Akan Datang</span>';
        }

        // Generate modal content
        const modalContent = `
            <div class="row">
                <div class="col-md-4">
                    <img src="${scholarship.image}" class="img-fluid rounded mb-3" alt="${scholarship.name}">

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Informasi Kontak</h5>
                            <div class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <a href="mailto:${scholarship.contact.email}">${scholarship.contact.email}</a>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <a href="tel:${scholarship.contact.phone}">${scholarship.contact.phone}</a>
                            </div>
                            <div>
                                <i class="fas fa-globe text-primary me-2"></i>
                                <a href="${scholarship.contact.website}" target="_blank">Website</a>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-lg btn-primary" ${scholarship.status !== 'Aktif' ? 'disabled' : ''}>
                            <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                        </button>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="text-primary">${scholarship.name}</h2>
                    <p class="mb-2">
                        ${statusBadge}
                        <span class="badge bg-light text-dark me-2">${scholarship.level}</span>
                        <span class="badge bg-light text-dark">${scholarship.coverage}</span>
                    </p>

                    <div class="d-flex gap-4 mb-4">
                        <div>
                            <small class="text-muted d-block">Penyedia</small>
                            <strong>${scholarship.provider}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Pendanaan</small>
                            <strong>${scholarship.fundingAmount}</strong>
                        </div>
                    </div>

                    <div class="alert alert-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-2 fa-lg"></i>
                            <div>
                                <div class="fw-bold">Periode Pendaftaran</div>
                                <div>${scholarship.startDate} - ${scholarship.endDate}</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Deskripsi</h5>
                    <p>${scholarship.description}</p>

                    ${requirementsHtml}
                    ${benefitsHtml}
                    ${documentsHtml}

                    <div class="mt-4">
                        <h5><i class="fas fa-bullhorn text-primary me-2"></i>Langkah Pendaftaran</h5>
                        <ol class="ps-3">
                            <li>Buat akun pada website resmi penyedia beasiswa</li>
                            <li>Lengkapi profil dan informasi pribadi</li>
                            <li>Unggah dokumen yang diperlukan</li>
                            <li>Isi formulir aplikasi</li>
                            <li>Tunggu proses seleksi dan pengumuman</li>
                        </ol>
                    </div>
                </div>
            </div>
        `;

        // Set modal content and show modal
        document.getElementById('modalContent').innerHTML = modalContent;
        const modal = new bootstrap.Modal(document.getElementById('scholarshipDetailModal'));
        modal.show();
    }

    // Function to filter scholarships based on search query
    function filterScholarships(query, filter = 'all') {
        let filtered = scholarships;

        // Filter by search query
        if (query) {
            query = query.toLowerCase();
            filtered = filtered.filter(scholarship => {
                return (
                    scholarship.name.toLowerCase().includes(query) ||
                    scholarship.provider.toLowerCase().includes(query) ||
                    scholarship.level.toLowerCase().includes(query) ||
                    scholarship.coverage.toLowerCase().includes(query)
                );
            });
        }

        // Filter by button category
        if (filter !== 'all') {
            if (filter === 'active') {
                filtered = filtered.filter(scholarship => scholarship.status === 'Aktif');
            } else {
                filtered = filtered.filter(scholarship => scholarship.category === filter);
            }
        }

        return filtered;
    }

    // Function to render scholarships
    function renderScholarships(filteredScholarships) {
        const container = document.getElementById('scholarshipsContainer');
        const noResults = document.getElementById('noResults');

        if (filteredScholarships.length === 0) {
            container.innerHTML = '';
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
            container.innerHTML = filteredScholarships.map(scholarship => {
                // Generate status badge HTML
                let statusBadge = '';
                if (scholarship.status === 'Aktif') {
                    statusBadge = '<span class="badge bg-success">Aktif</span>';
                } else if (scholarship.status === 'Ditutup') {
                    statusBadge = '<span class="badge bg-danger">Ditutup</span>';
                } else if (scholarship.status === 'Akan Datang') {
                    statusBadge = '<span class="badge bg-secondary">Akan Datang</span>';
                }

                return `
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm hover-shadow">
                            <div class="card-body p-0">
                                <div class="position-relative">
                                    <img src="${scholarship.image}" class="card-img-top" height="200" alt="${scholarship.name}">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        ${statusBadge}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="card-title">${scholarship.name}</h4>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <span>${scholarship.startDate} - ${scholarship.endDate}</span>
                                    </div>
                                    <p class="card-text">${scholarship.description.substring(0, 150)}...</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="badge bg-light text-dark me-1">${scholarship.level}</span>
                                            <span class="badge bg-light text-dark">${scholarship.coverage}</span>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(${scholarship.id})">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    // Initialize functionality when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initial render with all scholarships
        renderScholarships(scholarships);

        // Set up live search
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            // Get active filter
            const activeFilter = document.querySelector('.btn[data-filter].active').getAttribute('data-filter');
            const filteredScholarships = filterScholarships(query, activeFilter);
            renderScholarships(filteredScholarships);
        });

        // Set up filter buttons
        const filterButtons = document.querySelectorAll('.btn[data-filter]');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Filter scholarships
                const filter = this.getAttribute('data-filter');
                const query = document.getElementById('searchInput').value.trim();
                const filteredScholarships = filterScholarships(query, filter);
                renderScholarships(filteredScholarships);
            });
        });
    });
</script>
@endpush

