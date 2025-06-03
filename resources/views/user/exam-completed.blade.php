@extends('layouts.app')
@section('title', 'Hasil Tugas')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center p-5">
                    @if($isPassed)
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 130px; height: 130px;">
                            <i class="bi bi-check-lg text-success display-1"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Selamat, Anda Lulus!</h2>
                        <p class="text-muted mb-0">Nilai Anda: {{ number_format($score, 0) }}%</p>
                    </div>
                    <p class="mb-4">Anda telah berhasil menyelesaikan tugas ini dengan nilai sempurna. Lanjutkan untuk
                        mempelajari materi lainnya.</p>
                    @else
                    <div class="mb-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 130px; height: 130px;">
                            <i class="bi bi-x-lg text-danger display-1"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Belum Lulus</h2>
                        <p class="text-muted mb-0">Nilai Anda: {{ number_format($score, 0) }}%</p>
                    </div>
                    <p class="mb-4">Anda perlu mendapatkan nilai 100% untuk lulus. Silahkan pelajari kembali materi dan
                        ulangi tes.</p>
                    @endif

                    <div class="d-grid gap-2 d-sm-flex justify-content-center">
                        <a href="{{ route('e-course.show', $courseId) }}"
                            class="btn btn-primary px-4 py-2 rounded-pill">
                            Kembali ke E-Course
                        </a>
                        @if(!$isPassed)
                        <a href="{{ route('exam.start', ['courseId' => $courseId, 'examId' => $session->exam_id]) }}"
                            class="btn btn-outline-primary px-4 py-2 rounded-pill">
                            Coba Lagi
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Badge Award Modal -->
@if(isset($badge) && $badge)
<div class="modal fade" id="badgeAwardModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="badgeAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center p-5">
                <div class="badge-animation mb-4">
                    <div class="badge-glow"></div>
                    <img src="{{ asset('storage/' . $badge->badge->icon) }}" alt="{{ $badge->badge->name }}"
                        class="img-fluid badge-icon" style="max-width: 128px; height: auto;">
                </div>
                <h3 class="fw-bold text-primary mb-3">Selamat! Anda Mendapatkan Badge Baru</h3>
                <h4 class="badge-name mb-3">{{ $badge->badge->name }}</h4>
                <p class="text-muted">Anda telah menyelesaikan {{ $badge->badge->requirement }} tugas dengan nilai
                    sempurna!</p>
                <button type="button" class="btn btn-primary px-4 py-2 rounded-pill mt-3" data-bs-dismiss="modal">
                    Lanjutkan <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .badge-animation {
        position: relative;
        display: inline-block;
    }

    .badge-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 215, 0, 0.3);
        animation: glow 2s infinite ease-in-out;
    }

    .badge-icon {
        position: relative;
        z-index: 1;
        transition: transform 0.5s;
        animation: bounce 1s infinite alternate;
    }

    @keyframes glow {
        0% {
            box-shadow: 0 0 10px 5px rgba(255, 215, 0, 0.5);
            opacity: 0.8;
        }

        50% {
            box-shadow: 0 0 20px 10px rgba(255, 215, 0, 0.7);
            opacity: 1;
        }

        100% {
            box-shadow: 0 0 10px 5px rgba(255, 215, 0, 0.5);
            opacity: 0.8;
        }
    }

    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.05);
        }
    }

    .badge-name {
        color: #FF8C00;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($badge) && $badge)
        // Show the badge modal automatically when page loads
        var badgeModal = new bootstrap.Modal(document.getElementById('badgeAwardModal'));
        badgeModal.show();

        // Play sound if needed
        // const audioElement = new Audio('/sound/badge-awarded.mp3');
        // audioElement.play();
        @endif
    });
</script>
@endpush
