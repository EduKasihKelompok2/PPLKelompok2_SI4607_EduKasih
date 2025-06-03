@extends('layouts.app')
@section('title',$course->course_name ?? 'Detail E-Course')
@section('content')
<div class="container py-4">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('e-course') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke E-Course
        </a>
    </div>

    <div class="row">
        <!-- Left Side - Video and Course Info -->
        <div class="col-lg-7 mb-4">
            <!-- Video Player Section -->
            <div class="position-relative rounded-4 overflow-hidden mb-4">
                <div class="ratio ratio-16x9">
                    @php
                    $videoSrc = $currentVideo ? $currentVideo->getYoutubeEmbedUrl() :
                    'https://www.youtube.com/embed/1cQh0D0qMTg';
                    $videoTitle = $currentVideo ? $currentVideo->title : 'Preview Video';
                    @endphp
                    <iframe id="courseVideoPlayer" src="{{ $videoSrc }}" title="{{ $videoTitle }}"
                        allowfullscreen></iframe>
                </div>
            </div>

            <!-- Course Information -->
            <div class="d-flex align-items-center mb-3">
                <span class="text-muted">Mata Pelajaran {{ $course->nama_mapel }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold m-0">{{ $course->course_name }}</h3>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-star-fill text-warning"></i>
                        <span class="ms-1 fw-medium">{{ $course->rating }}</span>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center text-muted mb-4">
                <div class="me-3">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="ms-1">{{ $course->getTotalVideos() }} Materi</span>
                </div>
                <div class="me-3">
                    <i class="bi bi-clock"></i>
                    <span class="ms-1">{{ $course->getTotalDuration() }} Menit</span>
                </div>
            </div>

            <!-- About Section -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3">About</h5>
                <div class="about-content">
                    @php
                    $description = $course->description ?? 'No description available.';
                    // Parse to get first paragraph separately from the rest
                    $firstParagraphEndPos = strpos($description, '</p>');
                    $firstParagraph = $firstParagraphEndPos !== false ?
                    substr($description, 0, $firstParagraphEndPos + 4) : $description;
                    $remainingContent = $firstParagraphEndPos !== false ?
                    substr($description, $firstParagraphEndPos + 4) : '';
                    @endphp

                    <div class="text-muted description-content">
                        {!! $firstParagraph !!}
                    </div>

                    @if(!empty(trim($remainingContent)))
                    <div id="more-content" class="text-content collapse">
                        {!! $remainingContent !!}
                    </div>
                    <a href="#" class="text-primary text-decoration-none" data-bs-toggle="collapse"
                        data-bs-target="#more-content" aria-expanded="false" aria-controls="more-content"
                        id="read-more-btn">
                        Baca Selengkapnya <i class="bi bi-chevron-down ms-1 small"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side - Section List -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Daftar Materi</h5>
                    <small class="text-muted">{{ $course->getTotalDuration() }} Menit</small>
                </div>
                <div class="card-body p-3">
                    @if($courseVideos && $courseVideos->count() > 0)
                    @foreach($courseVideos->sortBy('order') as $index => $video)
                    <div class="mb-3">
                        <div
                            class="d-flex align-items-center p-3 rounded-4 bg-course-light border border-course-light {{ $currentVideo && $video->id == $currentVideo->id ? 'active-video' : '' }}">
                            <div class="d-flex align-items-center me-auto">
                                <div class="bg-white rounded-circle me-3 d-flex align-items-center justify-content-center video-play-btn"
                                    style="width: 40px; height: 40px; cursor: pointer;"
                                    data-video-src="{{ $video->getYoutubeEmbedUrl() }}"
                                    data-video-title="{{ $video->title }}">
                                    <i class="bi bi-play-fill fs-5 text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $video->title }}</div>
                                    <small class="text-muted">{{ $video->duration }} Menit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Kerjakan Tugas Button -->
                    <div class="mt-4">
                        @php
                        $exam = $course->exam;
                        $passedExam = false;

                        if($exam) {
                        $passedSession = Auth::user()->examSessions()
                        ->where('exam_id', $exam->id)
                        ->where('is_completed', true)
                        ->where('score', 100)
                        ->first();

                        $passedExam = !empty($passedSession);

                        $lastAttempt = Auth::user()->examSessions()
                        ->where('exam_id', $exam->id)
                        ->where('is_completed', true)
                        ->latest()
                        ->first();
                        }
                        @endphp

                        @if($passedExam)
                        <div class="alert alert-success d-flex align-items-center p-3 rounded-4">
                            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                            <div>
                                <span class="fw-bold">Selamat!</span> Anda telah lulus tes ini dengan nilai sempurna.
                            </div>
                        </div>
                        @else
                        @if($exam)
                        <button type="button" class="btn btn-primary w-100 position-relative py-3 rounded-4"
                            data-bs-toggle="modal" data-bs-target="#examConfirmModal">
                            <span class="fw-bold">Kerjakan Tugas</span>
                            <i class="bi bi-arrow-right position-absolute end-0 me-3"></i>
                        </button>
                        @else
                        <div class="alert alert-info d-flex align-items-center p-3 rounded-4">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div>Tidak ada tugas untuk kursus ini.</div>
                        </div>
                        @endif
                        @endif
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-film display-4 text-muted"></i>
                        <p class="mt-3">Belum ada materi video untuk e-course ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exam Confirmation Modal -->
<div class="modal fade" id="examConfirmModal" tabindex="-1" aria-labelledby="examConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 bg-primary bg-opacity-10 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 text-center">
                <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4"
                    style="width: 60px; height: 60px; margin-top: -50px;">
                    <i class="bi bi-journal-check fs-4"></i>
                </div>
                <h5 class="fw-bold mb-3" id="examConfirmModalLabel">Siap Mengerjakan Tugas?</h5>
                <p class="text-muted mb-4">Apakah Anda yakin ingin mengerjakan tugas ini? Pastikan Anda sudah
                    mempelajari semua materi.</p>

                @if(isset($lastAttempt) && $lastAttempt && $lastAttempt->score < 100) <div
                    class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Anda perlu mendapatkan nilai 100% untuk lulus tes ini.
                    <br>Nilai terakhir: {{ number_format($lastAttempt->score, 0) }}%
            </div>
            @elseif(isset($exam))
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Anda perlu mendapatkan nilai 100% untuk lulus tes ini.
            </div>
            @endif

            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <a href="{{ route('exam.start', $exam->id ) }}" class="btn btn-primary px-4 py-2 rounded-pill">
                    <i class="bi bi-play-circle me-1"></i> Mulai Sekarang
                </a>
            </div>
        </div>
        <div class="modal-footer border-0 pt-0 pb-3 justify-content-center">
            <small class="text-muted">Catatan: Anda akan memiliki waktu terbatas untuk menyelesaikan tugas</small>
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

    .active-video {
        background-color: #D4E4FF !important;
        border-left: 4px solid #4F46E5 !important;
    }

    .video-play-btn {
        transition: all 0.2s;
    }

    .video-play-btn:hover {
        background-color: #4F46E5 !important;
    }

    .video-play-btn:hover i {
        color: white !important;
    }

    /* Modal styling */
    .modal-content {
        overflow: hidden;
    }

    .modal-header {
        padding-top: 60px;
    }

    .bg-primary {
        background-color: #4F46E5 !important;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(79, 70, 229, 0.1) !important;
    }

    .rounded-pill {
        border-radius: 50rem;
    }

    .btn-outline-secondary {
        border-color: #d2d6dc;
        color: #6b7280;
    }

    .btn-outline-secondary:hover {
        background-color: #f9fafb;
        color: #4b5563;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreBtn = document.getElementById('read-more-btn');
        const moreContent = document.getElementById('more-content');

        if (moreContent && readMoreBtn) {
            moreContent.addEventListener('shown.bs.collapse', function () {
                readMoreBtn.innerHTML = 'Tampilkan Lebih Sedikit <i class="bi bi-chevron-up ms-1 small"></i>';
            });

            moreContent.addEventListener('hidden.bs.collapse', function () {
                readMoreBtn.innerHTML = 'Baca Selengkapnya <i class="bi bi-chevron-down ms-1 small"></i>';
            });
        }

        // Video player functionality
        const videoPlayer = document.getElementById('courseVideoPlayer');
        const playButtons = document.querySelectorAll('.video-play-btn');

        playButtons.forEach(button => {
            button.addEventListener('click', function() {
                const videoSrc = this.dataset.videoSrc;
                const videoTitle = this.dataset.videoTitle;

                // Update iframe source
                videoPlayer.src = videoSrc;
                videoPlayer.title = videoTitle;

                // Update active video styling
                document.querySelectorAll('.bg-course-light').forEach(item => {
                    item.classList.remove('active-video');
                });
                this.closest('.bg-course-light').classList.add('active-video');

                // Scroll to video player on mobile
                if (window.innerWidth < 992) {
                    document.querySelector('.position-relative.rounded-4').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush