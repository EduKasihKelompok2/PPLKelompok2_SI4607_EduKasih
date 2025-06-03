@extends('layouts.app')
@section('title',$course->course_name ?? 'Detail E-Course')
@section('content')
<div class="container py-4">
    <!-- Admin Controls Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.e-course') }}" class="btn btn-outline-primary me-3">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <h4 class="mb-0">Kelola E-Course</h4>
                        </div>
                        <div>
                            <a href="{{ route('admin.e-course.edit', $course->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil"></i> Edit E-Course
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteCourseModal">
                                <i class="bi bi-trash"></i> Hapus E-Course
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-pills mb-4" id="courseTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') != 'exam' ? 'active' : '' }}" id="materi-tab"
                data-bs-toggle="pill" data-bs-target="#materi-content" type="button" role="tab"
                aria-controls="materi-content" aria-selected="true">
                <i class="bi bi-play-circle me-1"></i> Materi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') == 'exam' ? 'active' : '' }}" id="exam-tab"
                data-bs-toggle="pill" data-bs-target="#exam-content" type="button" role="tab"
                aria-controls="exam-content" aria-selected="false">
                <i class="bi bi-file-earmark-text me-1"></i> Ujian
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="courseTabsContent">
        <!-- Materi Video Tab -->
        <div class="tab-pane fade {{ session('active_tab') != 'exam' ? 'show active' : '' }}" id="materi-content"
            role="tabpanel" aria-labelledby="materi-tab">
            <div class="row">
                <!-- Left Side - Video and Course Info -->
                <div class="col-lg-7 mb-4">
                    <!-- Video Player Section -->
                    <div class="position-relative rounded-4 overflow-hidden mb-4">
                        <div class="ratio ratio-16x9">
                            @php
                            $firstVideo = $courseVideos && $courseVideos->count() > 0 ?
                            $courseVideos->sortBy('order')->first()
                            : null;
                            $videoSrc = $firstVideo ? $firstVideo->getYoutubeEmbedUrl() :
                            'https://www.youtube.com/embed/1cQh0D0qMTg';
                            $videoTitle = $firstVideo ? $firstVideo->title : 'Preview Video';
                            @endphp
                            <iframe id="courseVideoPlayer" src="{{ $videoSrc }}" title="{{ $videoTitle }}"
                                allowfullscreen></iframe>
                        </div>
                    </div>

                    <!-- Course Information -->
                    <div class="d-flex align-items-center mb-3">
                        <span class="text-muted">Mata Pelajaran {{ $course->nama_mapel ?? '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold m-0">{{ $course->course_name ?? '-' }}</h3>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <span class="ms-1 fw-medium">{{ $course->rating ?? '4.7' }}</span>
                            </div>
                            <a href="#" class="btn btn-primary rounded-circle" title="Download Materi">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center text-muted mb-4">
                        <div class="me-3">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="ms-1">{{ $course->getTotalVideos() ?? '-' }} Materi</span>
                        </div>
                        <div class="me-3">
                            <i class="bi bi-clock"></i>
                            <span class="ms-1">{{ $course->getTotalDuration() ?? '0' }} Menit</span>
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

                <!-- Right Side - Course Video Management -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold">Daftar Materi</h5>
                                <small class="text-muted">{{ $course->getTotalDuration() ?? '0' }} Menit</small>
                            </div>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addVideoModal">
                                <i class="bi bi-plus-circle"></i> Tambah Materi
                            </button>
                        </div>
                        <div class="card-body p-3">
                            @if($courseVideos && $courseVideos->count() > 0)
                            @foreach($courseVideos as $index => $video)
                            <div class="mb-3">
                                <div
                                    class="d-flex align-items-center p-3 rounded-4 bg-course-light border border-course-light {{ $firstVideo && $video->id == $firstVideo->id ? 'active-video' : '' }}">
                                    <div class="d-flex align-items-center me-auto">
                                        <div class="bg-white rounded-circle me-3 d-flex align-items-center justify-content-center video-play-btn"
                                            style="width: 40px; height: 40px; cursor: pointer;"
                                            data-video-src="{{ $video->getYoutubeEmbedUrl() }}"
                                            data-video-title="{{ $video->title }}">
                                            <i class="bi bi-play-fill fs-5 text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $video->title }}</div>
                                            <small class="text-muted">{{ $video->duration ?? '5' }} Menit</small>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                                            data-bs-target="#editVideoModal" data-video-id="{{ $video->id }}"
                                            data-video-title="{{ $video->title }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteVideoModal" data-video-id="{{ $video->id }}"
                                            data-video-title="{{ $video->title }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-film display-4 text-muted"></i>
                                <p class="mt-3">Belum ada materi video untuk e-course ini.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Materi Video Pertama
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Tab -->
        <div class="tab-pane fade {{ session('active_tab') == 'exam' ? 'show active' : '' }}" id="exam-content"
            role="tabpanel" aria-labelledby="exam-tab">
            <div class="row">
                <!-- Left Side - Exam Info -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Detail Ujian</h5>
                            @if(!$course->exam)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addExamModal">
                                <i class="bi bi-plus-circle"></i> Buat Ujian
                            </button>
                            @endif
                        </div>
                        <div class="card-body p-4" id="examDetailsContent">
                            @php
                            $exam = $course->exam;
                            @endphp

                            @if($exam)
                            <div class="exam-details mb-4">
                                <h4 class="mb-3">{{ $exam->title }}</h4>
                                <div class="d-flex mb-3">
                                    <div class="me-4">
                                        <i class="bi bi-clock me-2"></i>
                                        <span>{{ $exam->duration_minutes }} Menit</span>
                                    </div>
                                    <div>
                                        <i class="bi bi-question-circle me-2"></i>
                                        <span>{{ $exam->questions->count() }} Pertanyaan</span>
                                    </div>
                                </div>

                                <div class="d-flex mt-3">
                                    <button class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editExamModal" data-exam-id="{{ $exam->id }}"
                                        data-exam-title="{{ $exam->title }}"
                                        data-exam-duration="{{ $exam->duration_minutes }}">
                                        <i class="bi bi-pencil me-1"></i> Edit Ujian
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="bi bi-file-earmark-text display-4 text-muted"></i>
                                <p class="mt-3">Belum ada ujian untuk e-course ini.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">
                                    <i class="bi bi-plus-circle me-2"></i>Buat Ujian
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Side - Questions Management -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Daftar Pertanyaan</h5>
                            @if($course->exam)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addQuestionModal">
                                <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
                            </button>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            @php
                            $exam = $course->exam;
                            @endphp

                            @if($exam && $exam->questions->count() > 0)
                            @foreach($exam->questions->sortBy('order') as $question)
                            <div class="mb-3">
                                <div
                                    class="d-flex align-items-start p-3 rounded-4 bg-course-light border border-course-light">
                                    <div class="me-3 bg-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="min-width: 30px; height: 30px;">
                                        <span class="fw-bold">{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="flex-grow-1 me-3">
                                        <div class="fw-bold mb-1">{{ \Illuminate\Support\Str::limit($question->question,
                                            60) }}</div>
                                        <div class="text-success small">
                                            <i class="bi bi-check-circle me-1"></i>Jawaban: {{
                                            strtoupper($question->correct_answer) }}
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                                            data-bs-target="#editQuestionModal" data-question-id="{{ $question->id }}"
                                            data-question-text="{{ $question->question }}"
                                            data-answer-a="{{ $question->answer_a }}"
                                            data-answer-b="{{ $question->answer_b }}"
                                            data-answer-c="{{ $question->answer_c }}"
                                            data-answer-d="{{ $question->answer_d }}"
                                            data-correct-answer="{{ $question->correct_answer }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteQuestionModal"
                                            data-question-id="{{ $question->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif($exam)
                            <div class="text-center py-4">
                                <i class="bi bi-question-circle display-4 text-muted"></i>
                                <p class="mt-3">Belum ada pertanyaan untuk ujian ini.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addQuestionModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Pertanyaan Pertama
                                </button>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-muted">Buat ujian terlebih dahulu untuk menambahkan pertanyaan.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVideoModalLabel">Tambah Materi Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.course-video.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_code" value="{{ $course->course_code ?? '' }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">URL Video (YouTube)</label>
                        <input type="text" class="form-control" id="video_url" name="video_url"
                            placeholder="https://www.youtube.com/watch?v=..." required>
                        <small class="text-muted">Masukkan link YouTube lengkap</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Durasi (menit)</label>
                                <input type="number" class="form-control" id="duration" name="duration" min="1"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Urutan</label>
                                <input type="number" class="form-control" id="order" name="order" min="1"
                                    value="{{ ($courseVideos ? $courseVideos->count() : 0) + 1 }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVideoModalLabel">Edit Materi Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVideoForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_video_url" class="form-label">URL Video (YouTube)</label>
                        <input type="text" class="form-control" id="edit_video_url" name="video_url"
                            placeholder="https://www.youtube.com/watch?v=..." required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_duration" class="form-label">Durasi (menit)</label>
                                <input type="number" class="form-control" id="edit_duration" name="duration" min="1"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_order" class="form-label">Urutan</label>
                                <input type="number" class="form-control" id="edit_order" name="order" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Video Modal -->
<div class="modal fade" id="deleteVideoModal" tabindex="-1" aria-labelledby="deleteVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVideoModalLabel">Hapus Materi Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus materi video "<span id="videoTitleToDelete"></span>"?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteVideoForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Course Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCourseModalLabel">Hapus E-Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus e-course "{{ $course->course_name ?? 'Matematika Dasar' }}"?</p>
                <p class="text-danger"><small>Semua materi video terkait juga akan dihapus. Tindakan ini tidak dapat
                        dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.e-course.destroy', $course->id ?? '1') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExamModalLabel">Buat Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.exams.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id ?? '' }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exam_title" class="form-label">Judul Ujian</label>
                        <input type="text" class="form-control" id="exam_title" name="title"
                            placeholder="Ujian Akhir {{ $course->course_name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                        <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" min="1"
                            value="60" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Exam Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="editExamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExamModalLabel">Edit Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editExamForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_exam_title" class="form-label">Judul Ujian</label>
                        <input type="text" class="form-control" id="edit_exam_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_duration_minutes" class="form-label">Durasi (menit)</label>
                        <input type="number" class="form-control" id="edit_duration_minutes" name="duration_minutes"
                            min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Tambah Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.exams.questions.store', $course->exam ? $course->exam->id : 0) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar (opsional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="answer_a" class="form-label">Pilihan A</label>
                            <input type="text" class="form-control" id="answer_a" name="answer_a" required>
                        </div>
                        <div class="col-md-6">
                            <label for="answer_b" class="form-label">Pilihan B</label>
                            <input type="text" class="form-control" id="answer_b" name="answer_b" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="answer_c" class="form-label">Pilihan C</label>
                            <input type="text" class="form-control" id="answer_c" name="answer_c" required>
                        </div>
                        <div class="col-md-6">
                            <label for="answer_d" class="form-label">Pilihan D</label>
                            <input type="text" class="form-control" id="answer_d" name="answer_d" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Jawaban Benar</label>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="correct_answer" id="correct_a" value="a"
                                required>
                            <label class="btn btn-outline-primary" for="correct_a">A</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="correct_b" value="b">
                            <label class="btn btn-outline-primary" for="correct_b">B</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="correct_c" value="c">
                            <label class="btn btn-outline-primary" for="correct_c">C</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="correct_d" value="d">
                            <label class="btn btn-outline-primary" for="correct_d">D</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel">Edit Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editQuestionForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="edit_question" name="question" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Gambar (opsional)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div id="current_image_container" class="mt-2 d-none">
                            <p class="mb-1">Gambar saat ini:</p>
                            <img id="current_image" src="" alt="Current Question Image" class="img-thumbnail"
                                style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_answer_a" class="form-label">Pilihan A</label>
                            <input type="text" class="form-control" id="edit_answer_a" name="answer_a" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_answer_b" class="form-label">Pilihan B</label>
                            <input type="text" class="form-control" id="edit_answer_b" name="answer_b" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_answer_c" class="form-label">Pilihan C</label>
                            <input type="text" class="form-control" id="edit_answer_c" name="answer_c" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_answer_d" class="form-label">Pilihan D</label>
                            <input type="text" class="form-control" id="edit_answer_d" name="answer_d" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Jawaban Benar</label>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="correct_answer" id="edit_correct_a" value="a"
                                required>
                            <label class="btn btn-outline-primary" for="edit_correct_a">A</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="edit_correct_b" value="b">
                            <label class="btn btn-outline-primary" for="edit_correct_b">B</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="edit_correct_c" value="c">
                            <label class="btn btn-outline-primary" for="edit_correct_c">C</label>

                            <input type="radio" class="btn-check" name="correct_answer" id="edit_correct_d" value="d">
                            <label class="btn btn-outline-primary" for="edit_correct_d">D</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Question Modal -->
<div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-labelledby="deleteQuestionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteQuestionModalLabel">Hapus Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pertanyaan ini?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteQuestionForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
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

    /* Fix for CKEditor conflict with Bootstrap */
    .ck-editor__editable_inline {
        min-height: 150px;
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
        color: white !important;
    }

    .video-play-btn:hover i {
        color: white !important;
    }

    /* Tab styling */
    .nav-pills .nav-link {
        color: #6c757d;
        border-radius: 0.5rem;
        padding: 0.6rem 1.2rem;
        margin-right: 0.5rem;
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background-color: #4F46E5;
        color: white;
    }

    /* Button group */
    .btn-group .btn-outline-primary:not(:first-child) {
        margin-left: -1px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab initialization
        const triggerTabList = document.querySelectorAll('#courseTabs button');
        triggerTabList.forEach(triggerEl => {
            new bootstrap.Tab(triggerEl);
        });

        // Check for active tab from session
        const activeTab = "{{ session('active_tab') }}";
        if (activeTab === 'exam') {
            document.getElementById('exam-tab').click();
        }

        // Read more/less functionality
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

        // Handle edit video modal
        const editVideoModal = document.getElementById('editVideoModal');
        if (editVideoModal) {
            editVideoModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const videoId = button.getAttribute('data-video-id');
                const videoTitle = button.getAttribute('data-video-title');

                // Set the form action URL with the correct video ID
                const form = document.getElementById('editVideoForm');
                form.action = `/admin/course-video/${videoId}`;

                // You would typically load the video data via AJAX here
                // For now, we'll just set the title
                document.getElementById('edit_title').value = videoTitle;

                // Fetch the video data using AJAX
                fetch(`/admin/course-video/${videoId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_title').value = data.title;
                        document.getElementById('edit_video_url').value = data.video_url;
                        document.getElementById('edit_duration').value = data.duration;
                        document.getElementById('edit_order').value = data.order;
                    })
                    .catch(error => console.error('Error fetching video data:', error));
            });
        }

        // Handle delete video modal
        const deleteVideoModal = document.getElementById('deleteVideoModal');
        if (deleteVideoModal) {
            deleteVideoModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const videoId = button.getAttribute('data-video-id');
                const videoTitle = button.getAttribute('data-video-title');

                document.getElementById('videoTitleToDelete').textContent = videoTitle;

                const form = document.getElementById('deleteVideoForm');
                form.action = `/admin/course-video/${videoId}`;
            });
        }

        // Handle edit exam modal
        const editExamModal = document.getElementById('editExamModal');
        if (editExamModal) {
            editExamModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const examId = button.getAttribute('data-exam-id');
                const examTitle = button.getAttribute('data-exam-title');
                const examDuration = button.getAttribute('data-exam-duration');

                const form = document.getElementById('editExamForm');
                form.action = `/admin/exams/${examId}`;

                document.getElementById('edit_exam_title').value = examTitle;
                document.getElementById('edit_duration_minutes').value = examDuration;
            });
        }

        // Handle edit question modal
        const editQuestionModal = document.getElementById('editQuestionModal');
        if (editQuestionModal) {
            editQuestionModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const questionId = button.getAttribute('data-question-id');
                const questionText = button.getAttribute('data-question-text');
                const answerA = button.getAttribute('data-answer-a');
                const answerB = button.getAttribute('data-answer-b');
                const answerC = button.getAttribute('data-answer-c');
                const answerD = button.getAttribute('data-answer-d');
                const correctAnswer = button.getAttribute('data-correct-answer');

                // Set form action for the specific question
                const examId = @json($course->exam ? $course->exam->id : 0);
                const form = document.getElementById('editQuestionForm');
                form.action = `/admin/exams/${examId}/questions/${questionId}`;

                // Populate form fields
                document.getElementById('edit_question').value = questionText;
                document.getElementById('edit_answer_a').value = answerA;
                document.getElementById('edit_answer_b').value = answerB;
                document.getElementById('edit_answer_c').value = answerC;
                document.getElementById('edit_answer_d').value = answerD;

                // Set correct answer radio button
                document.getElementById(`edit_correct_${correctAnswer}`).checked = true;

                // Fetch question details to get image if exists
                fetch(`/admin/exams/${examId}/questions/${questionId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.image_path) {
                            document.getElementById('current_image_container').classList.remove('d-none');
                            document.getElementById('current_image').src = '/storage/' + data.image_path;
                        } else {
                            document.getElementById('current_image_container').classList.add('d-none');
                        }
                    })
                    .catch(error => console.error('Error fetching question data:', error));
            });
        }

        // Handle delete question modal
        const deleteQuestionModal = document.getElementById('deleteQuestionModal');
        if (deleteQuestionModal) {
            deleteQuestionModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const questionId = button.getAttribute('data-question-id');

                // Set form action for the specific question
                const examId = @json($course->exam ? $course->exam->id : 0);
                const form = document.getElementById('deleteQuestionForm');
                form.action = `/admin/exams/${examId}/questions/${questionId}`;
            });
        }
    });
</script>
@endpush