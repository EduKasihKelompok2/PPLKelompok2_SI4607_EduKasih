@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Left Side - Video and Course Info -->
        <div class="col-lg-7 mb-4">
            <!-- Video Player Section -->
            <div class="position-relative rounded-4 overflow-hidden mb-4">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/1cQh0D0qMTg" title="Matematika Dasar"
                        allowfullscreen></iframe>
                </div>
            </div>

            <!-- Course Information -->
            <div class="d-flex align-items-center mb-3">
                <span class="text-muted">Mata Pelajaran Matematika</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold m-0">Matematika Dasar | Part 1</h3>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-star-fill text-warning"></i>
                        <span class="ms-1 fw-medium">4.7</span>
                    </div>
                    <a href="#" class="btn btn-primary rounded-circle" title="Download Materi">
                        <i class="bi bi-download"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex align-items-center text-muted mb-4">
                <div class="me-3">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="ms-1">5 Materi</span>
                </div>
                <div class="me-3">
                    <i class="bi bi-clock"></i>
                    <span class="ms-1">45 Menit</span>
                </div>
            </div>

            <!-- About Section -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">About</h5>
                <div class="about-content">
                    <p class="text-muted">
                        Matematika Dasar adalah fondasi penting dalam memahami konsep angka dan perhitungan. Materi ini
                        mencakup aritmetika,
                        aljabar dasar, geometri, dan pengenalan statistika yang diterapkan dalam kehidupan sehari-hari.
                    </p>
                    <div id="more-content" class="collapse">
                        <p class="text-muted">
                            Dalam kursus ini, siswa akan mempelajari operasi bilangan bulat, pecahan, desimal, konsep
                            perbandingan,
                            persentase, dan dasar-dasar pengukuran. Semua topik dijelaskan dengan contoh praktis dan
                            latihan interaktif
                            untuk memastikan pemahaman yang mendalam.
                        </p>
                        <p class="text-muted">
                            Metode pembelajaran kami mengkombinasikan video tutorial, materi tertulis, dan latihan soal
                            bertingkat untuk
                            mengakomodasi berbagai gaya belajar. Setiap modul dirancang agar siswa dapat membangun
                            kepercayaan diri dan
                            keterampilan pemecahan masalah.
                        </p>
                    </div>
                    <a href="#" class="text-primary text-decoration-none" data-bs-toggle="collapse"
                        data-bs-target="#more-content" aria-expanded="false" aria-controls="more-content"
                        id="read-more-btn">
                        Baca Selengkapnya <i class="bi bi-chevron-down ms-1 small"></i>
                    </a>
                </div>
            </div>

            <!-- Additional Resources Optional -->
            {{-- <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Materi Pendukung</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="bg-light rounded p-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-file-pdf text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium">Rangkuman Matematika Dasar.pdf</div>
                            <small class="text-muted">2.5 MB</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i></a>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-light rounded p-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-file-earmark-text text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium">Latihan Soal Matematika Dasar.docx</div>
                            <small class="text-muted">1.2 MB</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i></a>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Right Side - Section List -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Pengenalan Konsep</h5>
                    <small class="text-muted">50 Menit</small>
                </div>
                <div class="card-body p-3">
                    @php
                    $materi = [
                    'Detail Materi 1',
                    'Detail Materi 2',
                    'Detail Materi 3',
                    'Detail Materi 4',
                    'Detail Materi 5',
                    'Detail Materi 6'
                    ];
                    @endphp

                    @foreach($materi as $index => $item)
                    <div class="mb-3">
                        <div class="d-flex align-items-center p-3 rounded-4 bg-course-light border border-course-light">
                            <div class="d-flex align-items-center me-auto">
                                <div class="bg-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <span class="fw-medium">01</span>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $item }}</div>
                                    <small class="text-muted">5 Menit</small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary rounded-circle">
                                <i class="bi bi-play-fill"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4">
                        <a href="#" class="btn btn-primary w-100 position-relative py-3 rounded-4">
                            <span class="fw-bold">Kerjakan Tugas</span>
                            <i class="bi bi-arrow-right position-absolute end-0 me-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-course-light {
        background-color: #E8F1FF;
    }

    .border-course-light {
        border-color: #D4E4FF !important;
    }

    .play-button {
        cursor: pointer;
        opacity: 0.9;
        transition: all 0.2s;
    }

    .play-button:hover {
        transform: scale(1.1);
        opacity: 1;
    }

    .rounded-4 {
        border-radius: 0.75rem;
    }

    .card {
        border-radius: 0.75rem;
    }

    .card-header {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }

    .btn-primary {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }

    .btn-outline-primary {
        border-color: #4F46E5;
        color: #4F46E5;
    }

    .btn-outline-primary:hover {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }

    .text-primary {
        color: #4F46E5 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreBtn = document.getElementById('read-more-btn');
        const moreContent = document.getElementById('more-content');

        moreContent.addEventListener('shown.bs.collapse', function () {
            readMoreBtn.innerHTML = 'Tampilkan Lebih Sedikit <i class="bi bi-chevron-up ms-1 small"></i>';
        });

        moreContent.addEventListener('hidden.bs.collapse', function () {
            readMoreBtn.innerHTML = 'Baca Selengkapnya <i class="bi bi-chevron-down ms-1 small"></i>';
        });
    });
</script>
@endpush