@extends('layout.app')
@section('title', 'E-Course')
@section('content')
<div class="container">
    <div class="row">
        <h1>E-Course</h>
        <p>Jelajahi berbagai e-course terbaik yang dirancang untuk membantu
            siswa SMA memahami konsep dengan lebih mudah dan menyenangkan.
            Dari Matematika hingga Bahasa, temukan materi yang sesuai dengan
            kebutuhan belajar Anda dan tingkatkan prestasi akademik Anda!</p>
    </div>
    <div>
        <form method="GET" action="{{ route('e-course') }}">
            <input type="search" name="query" value="{{ query }}">
            <button>Cari</button>
        </form>
    </div>

    @foreach($courses as $c)
    <div>
        <img src="{{ $c->image }}">
        <h2>{{ $c->judul }}</h2>
        <p>{{ $c->desc }}</p>
    </div>
    @endforeach
</div>
@endsection