@extends('layouts.app')
@section('title', 'Edit E-Course')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3">
                    <h1 class="fw-bold fs-4 mb-0">Edit E-Course</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.e-course.update', $course->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="course_code" class="form-label">Kode Kursus</label>
                            <input type="text" class="form-control @error('course_code') is-invalid @enderror"
                                id="course_code" name="course_code"
                                value="{{ old('course_code', $course->course_code) }}" required>
                            <div class="form-text">Perubahan kode kursus mungkin mempengaruhi video terkait.</div>
                            @error('course_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="course_name" class="form-label">Nama E-Course</label>
                            <input type="text" class="form-control @error('course_name') is-invalid @enderror"
                                id="course_name" name="course_name"
                                value="{{ old('course_name', $course->course_name) }}" required>
                            @error('course_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_mapel" class="form-label">Mata Pelajaran</label>
                            <select class="form-select @error('nama_mapel') is-invalid @enderror" id="nama_mapel"
                                name="nama_mapel" required>
                                <option value="" disabled>Pilih Mata Pelajaran</option>
                                @php
                                $categories = [
                                'Fisika', 'Kimia', 'Matematika', 'Biologi', 'Bahasa Inggris',
                                'Bahasa Indonesia', 'Sejarah', 'Geografi', 'Ekonomi', 'Sosiologi'
                                ];
                                @endphp

                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('nama_mapel', $course->nama_mapel) == $category ?
                                    'selected' : ''
                                    }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                            @error('nama_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="10">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Cover</label>
                            @if($course->image)
                            <div class="mb-2">
                                <img src="{{ asset($course->image) }}" alt="{{ $course->course_name }}"
                                    class="img-thumbnail" style="height: 100px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating"
                                name="rating" value="{{ old('rating', $course->rating) }}" min="1" max="5" step="0.1">
                            @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.e-course.show', $course->id) }}"
                                class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem;
    }

    .card-header {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }

    /* Fix for CKEditor conflict with Bootstrap */
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush