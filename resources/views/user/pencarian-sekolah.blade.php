@extends('layouts.app')
@section('title', 'Pencarian Sekolah')
@section('content')
<div class="container py-4">
    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari perguruan tinggi..."
                            autocomplete="off">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schools Grid -->
    <div class="row" id="schoolsContainer">
        <!-- Schools will be dynamically inserted here -->
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="col-12 text-center py-5 d-none">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Tidak ada hasil yang ditemukan
        </div>
    </div>
</div>

<!-- School Detail Modal -->
<div class="modal fade" id="schoolDetailModal" tabindex="-1" aria-labelledby="schoolDetailModalLabel"
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
    // Dummy school data
    const schools = [
        {
            id: 1,
            name: "Universitas Indonesia",
            type: "Perguruan Tinggi Negeri",
            accreditation: "Terakreditasi A",
            city: "Depok",
            province: "Jawa Barat",
            foundedYear: 1849,
            status: "Aktif",
            students: "~50,000",
            image: "https://www.ui.ac.id/wp-content/uploads/2022/12/home_whyui-700x450.jpg", // Placeholder image
            description: "Universitas Indonesia (UI) adalah salah satu universitas riset atau institusi akademik tertua di Asia yang didirikan pada abad ke-19. UI menawarkan berbagai program pendidikan, penelitian, dan pengabdian masyarakat, serta memelihara warisan budaya.",
            faculties: [
                {
                    name: "Fakultas Kedokteran",
                    programs: ["Pendidikan Dokter", "Ilmu Keperawatan", "Ilmu Kesehatan Masyarakat"]
                },
                {
                    name: "Fakultas Teknik",
                    programs: ["Teknik Sipil", "Teknik Elektro", "Teknik Mesin", "Teknik Komputer"]
                },
                {
                    name: "Fakultas Ekonomi & Bisnis",
                    programs: ["Manajemen", "Akuntansi", "Ilmu Ekonomi", "Bisnis Islam"]
                }
            ],
            address: "Kampus UI Depok, Jawa Barat 16424",
            website: "https://www.ui.ac.id",
            instagram: "@universitasindonesia",
            contact: "(021) 7867222"
        },
        {
            id: 2,
            name: "Institut Teknologi Bandung",
            type: "Perguruan Tinggi Negeri",
            accreditation: "Terakreditasi A",
            city: "Bandung",
            province: "Jawa Barat",
            foundedYear: 1920,
            status: "Aktif",
            students: "~25,000",
            image: "https://asset-2.tstatic.net/tribunnewswiki/foto/bank/images/institut-teknologi-bandung-itb.jpg", // Placeholder image
            description: "Institut Teknologi Bandung (ITB) adalah sebuah perguruan tinggi negeri yang berkedudukan di Kota Bandung. ITB merupakan perguruan tinggi tertua di Indonesia dalam bidang teknologi.",
            faculties: []
        },
        {
            id: 3,
            name: "Universitas Gadjah Mada",
            type: "Perguruan Tinggi Negeri",
            accreditation: "Terakreditasi A",
            city: "Yogyakarta",
            province: "DI Yogyakarta",
            foundedYear: 1949,
            status: "Aktif",
            students: "~55,000",
            image: "https://ugm.ac.id/wp-content/uploads/2024/06/WhatsApp-Image-2024-06-05-at-08.43.46-4.jpeg", // Placeholder image
            description: "Universitas Gadjah Mada (UGM) adalah universitas negeri di Indonesia yang didirikan pada tahun 1949. UGM merupakan universitas tertua dan terbesar di Indonesia.",
            faculties: []
        },
        {
            id: 4,
            name: "Universitas Airlangga",
            type: "Perguruan Tinggi Negeri",
            accreditation: "Terakreditasi A",
            city: "Surabaya",
            province: "Jawa Timur",
            foundedYear: 1954,
            status: "Aktif",
            students: "~38,000",
            image: "https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvMzkvMzcvMWZlNjM4YjQtYWY3NC00OGU0LThjMWEtODIwN2U1ZTdjYTkwLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=bfa1f7c48f302732", // Placeholder image
            description: "Universitas Airlangga (UNAIR) adalah sebuah perguruan tinggi negeri yang terletak di Surabaya, Jawa Timur. UNAIR didirikan pada tahun 1954 dan merupakan salah satu universitas tertua di Indonesia.",
            faculties: []
        },
        {
            id: 5,
            name: "Universitas Padjadjaran",
            type: "Perguruan Tinggi Negeri",
            accreditation: "Terakreditasi A",
            city: "Bandung",
            province: "Jawa Barat",
            foundedYear: 1957,
            status: "Aktif",
            students: "~45,000",
            image: "https://www.griksa.com/wp-content/uploads/2022/05/REKTORAT-UNPAD-2.jpg", // Placeholder image
            description: "Universitas Padjadjaran (UNPAD) adalah sebuah perguruan tinggi negeri yang berkedudukan di Jatinangor, Kabupaten Sumedang, Jawa Barat. UNPAD didirikan pada tahun 1957 dan merupakan salah satu perguruan tinggi terkemuka di Indonesia.",
            faculties: []
        },
        {
            id: 6,
            name: "Telkom University",
            type: "Perguruan Tinggi Swasta",
            accreditation: "Terakreditasi Unggul",
            city: "Bandung",
            province: "Jawa Barat",
            foundedYear: 2013,
            status: "Aktif",
            students: "~30,000",
            image: "https://b856188.smushcdn.com/856188/wp-content/uploads/2024/09/Telkom-University-Bandung-Main-Campus.png?lossy=2&strip=0&webp=1", // Placeholder image
            description: "Telkom University (Tel-U) adalah perguruan tinggi swasta yang berlokasi di Bandung, Jawa Barat. Tel-U dikenal sebagai salah satu universitas terbaik di Indonesia dalam bidang teknologi dan komunikasi.",
            faculties: [
            {
                name: "Fakultas Teknik Elektro",
                programs: ["Teknik Telekomunikasi", "Teknik Elektro", "Teknik Komputer"]
            },
            {
                name: "Fakultas Informatika",
                programs: ["Informatika", "Sistem Informasi", "Teknologi Informasi"]
            },
            {
                name: "Fakultas Ekonomi dan Bisnis",
                programs: ["Manajemen", "Akuntansi", "Bisnis Digital"]
            },
            {
                name: "Fakultas Industri Kreatif",
                programs: ["Desain Komunikasi Visual", "Desain Interior", "Desain Produk"]
            }
            ],
            address: "Jl. Telekomunikasi No. 1, Bandung, Jawa Barat 40257",
            website: "https://www.telkomuniversity.ac.id",
            instagram: "@telkomuniversity",
            contact: "(022) 7564108"
        }
    ];

    // Function to create school card
    // For the source, it will changed later version to asset()
    function createSchoolCard(school) {
        return `
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <img src="${school.image}" class="card-img-top" height="200"
                        alt="${school.name}">
                    <div class="card-body text-center">
                        <h5 class="card-title">${school.name}</h5>
                        <p class="card-text text-muted small mb-2">
                            ${school.city}, ${school.province}
                        </p>
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="showSchoolDetail(${school.id})">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to display school detail in modal
    function showSchoolDetail(schoolId) {
        const school = schools.find(s => s.id === schoolId);
        if (!school) return;

        // Generate faculty HTML
        let facultiesHtml = '';
        if (school.faculties && school.faculties.length > 0) {
            facultiesHtml = `
                <h5 class="mt-4">Fakultas dan Program Studi</h5>
                <div class="row">
            `;

            school.faculties.forEach(faculty => {
                facultiesHtml += `
                    <div class="col-md-6">
                        <h6 class="text-primary">${faculty.name}</h6>
                        <ul>
                            ${faculty.programs.map(program => `<li>${program}</li>`).join('')}
                        </ul>
                    </div>
                `;
            });

            facultiesHtml += '</div>';
        }

        // Generate modal content
        // For the source, it will changed later version to asset()
        const modalContent = `
            <div class="row">
                <div class="col-md-4">
                    <img src="${school.image}" class="img-fluid rounded"
                        alt="${school.name}">
                    <div class="mt-3">
                        <div class="d-grid gap-2">
                            <a href="${school.website || '#'}" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-globe me-1"></i> Website
                            </a>
                            <a href="https://instagram.com/${school.instagram?.replace('@', '') || ''}" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fab fa-instagram me-1"></i> Instagram
                            </a>
                            <a href="tel:${school.contact || ''}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-phone me-1"></i> Kontak
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="text-primary">${school.name}</h2>
                    <p class="mb-2">
                        <span class="badge bg-primary me-2">${school.type}</span>
                        <span class="badge bg-light text-dark">${school.accreditation}</span>
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        ${school.address || `${school.city}, ${school.province}`}
                    </p>
                    <div class="d-flex gap-3 mb-3">
                        <div>
                            <small class="text-muted d-block">Didirikan</small>
                            <strong>${school.foundedYear}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Status</small>
                            <strong>${school.status}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Mahasiswa</small>
                            <strong>${school.students}</strong>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4">Tentang</h5>
                    <p>${school.description}</p>

                    ${facultiesHtml}
                </div>
            </div>
        `;

        // Set modal content and show modal
        document.getElementById('modalContent').innerHTML = modalContent;
        const modal = new bootstrap.Modal(document.getElementById('schoolDetailModal'));
        modal.show();
    }

    // Function to filter schools based on search query
    function filterSchools(query) {
        if (!query) {
            return schools;
        }

        query = query.toLowerCase();
        return schools.filter(school => {
            return (
                school.name.toLowerCase().includes(query) ||
                school.city.toLowerCase().includes(query) ||
                school.province.toLowerCase().includes(query) ||
                school.type.toLowerCase().includes(query)
            );
        });
    }

    // Function to render schools
    function renderSchools(filteredSchools) {
        const container = document.getElementById('schoolsContainer');
        const noResults = document.getElementById('noResults');

        if (filteredSchools.length === 0) {
            container.innerHTML = '';
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
            container.innerHTML = filteredSchools.map(school => createSchoolCard(school)).join('');
        }
    }

    // Initialize search functionality when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initial render with all schools
        renderSchools(schools);

        // Set up live search
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            const filteredSchools = filterSchools(query);
            renderSchools(filteredSchools);
        });
    });
</script>
@endpush