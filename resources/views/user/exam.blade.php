<!-- resources/views/exam/math-question.blade.php -->
@extends('layouts.app')
@section('title', $exam->title)
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">{{ $exam->title }}</h5>
                <div class="text-muted" id="timer" data-remaining="{{ $session->remaining_time }}">
                    Timer: {{ $session->remaining_time_formatted }}
                </div>
            </div>

            <p class="text-muted small mb-4">Jawablah pertanyaan dibawah ini</p>

            <form id="question-form" action="{{ route('exam.submit-answer', $session->id) }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">

                <div class="row">
                    @if($question->image_path)
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <img src="{{ asset('storage/' . $question->image_path) }}" class="img-fluid rounded"
                                alt="Question Image" style="max-height: 300px;">
                        </div>
                    </div>
                    @endif

                    <div class="col-md-{{ $question->image_path ? '6' : '12' }}">
                        <div class="py-2">
                            <p class="fw-medium mb-2">Pertanyaan {{ $currentQuestionNumber }}/{{ $totalQuestions }}</p>
                            <p>{{ $question->question }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="fw-medium mb-3">Pilih Jawaban</p>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" id="answer_a" value="a" {{
                            $userAnswer==='a' ? 'checked' : '' }}>
                        <label class="form-check-label" for="answer_a">
                            {{ $question->answer_a }}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" id="answer_b" value="b" {{
                            $userAnswer==='b' ? 'checked' : '' }}>
                        <label class="form-check-label" for="answer_b">
                            {{ $question->answer_b }}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" id="answer_c" value="c" {{
                            $userAnswer==='c' ? 'checked' : '' }}>
                        <label class="form-check-label" for="answer_c">
                            {{ $question->answer_c }}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" id="answer_d" value="d" {{
                            $userAnswer==='d' ? 'checked' : '' }}>
                        <label class="form-check-label" for="answer_d">
                            {{ $question->answer_d }}
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <div>
                        @if($currentQuestionNumber > 1)
                        <button type="submit" name="prev" value="1"
                            class="btn btn-outline-secondary">Sebelumnya</button>
                        @endif
                    </div>
                    <div>
                        @if($currentQuestionNumber < $totalQuestions) <button type="submit" name="next" value="1"
                            class="btn btn-primary">Selanjutnya</button>
                            @else
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#submitConfirmModal">Selesai</button>
                            @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="submitConfirmModal" tabindex="-1" aria-labelledby="submitConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitConfirmModalLabel">Konfirmasi Pengumpulan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengumpulkan jawaban?</p>
                <p class="text-muted">Setelah dikumpulkan, Anda tidak dapat mengubah jawaban lagi.</p>
                <p class="text-warning"><strong>Catatan:</strong> Anda perlu mendapatkan nilai 100% untuk lulus tes ini.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <form action="{{ route('exam.complete', $session->id) }}" method="POST" id="complete-form">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="hidden" name="answer" id="final-answer" value="{{ $userAnswer }}">
                    <button type="submit" class="btn btn-success">Ya, Kumpulkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timerElement = document.getElementById('timer');
        let remainingSeconds = parseInt(timerElement.dataset.remaining);

        document.querySelectorAll('input[name="answer"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('final-answer').value = this.value;
            });
        });

        const submitConfirmModal = document.getElementById('submitConfirmModal');
        submitConfirmModal.addEventListener('show.bs.modal', function() {
            const selectedAnswer = document.querySelector('input[name="answer"]:checked');
            if (selectedAnswer) {
                document.getElementById('final-answer').value = selectedAnswer.value;
            }
        });

        const updateTimer = function() {
            if (remainingSeconds <= 0) {
                document.getElementById('question-form').submit();
                return;
            }

            let minutes = Math.floor(remainingSeconds / 60);
            let seconds = remainingSeconds % 60;
            timerElement.textContent = `Timer: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            remainingSeconds--;
        };

        updateTimer();
        setInterval(updateTimer, 1000);
    });
</script>
@endpush
@endsection