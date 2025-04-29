@extends('layouts.app')
@section('title', 'E-Course')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col">
            <h1 class="fw-bold">E-Course</h1>
            <p>Jelajahi berbagai e-course terbaik yang dirancang untuk membantu
                siswa SMA memahami konsep dengan lebih mudah dan menyenangkan.
                Dari Matematika hingga Bahasa, temukan materi yang sesuai dengan
                kebutuhan belajar Anda dan tingkatkan prestasi akademik Anda!</p>
        </div>
    </div>
    <form method="GET" action="{{ route('e-course') }}">
        <input type="text" name="query" value="{{ request('query') }}" placeholder="Cari materi...">
        <button type="submit">Cari</button>
    </form>

    @if($courses->count() > 0)
        @foreach($courses as $course)
        <div>
            <img src="{{ $course->image }}" alt="Gambar">
            <h2>{{ $course->title }}</h2>
            <p>{{ $course->description }}</p>
        </div>
        @endforeach
    @else
        <p>Tidak ada kursus ditemukan.</p>
    @endif
</div>
@endsection