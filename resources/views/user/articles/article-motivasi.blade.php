@extends('layouts.app')

@section('title', 'Artikel Motivasi')

@push('styles')
<style>
    .article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .article-img-container {
        height: 200px;
        overflow: hidden;
    }

    .article-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-date {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .article-description {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .search-container {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .page-title {
        color: #343a40;
        font-weight: 700;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        font-weight: 500;
        padding: 12px 20px;
    }

    .nav-tabs .nav-link.active {
        font-weight: 600;
        border-bottom: 3px solid #0d6efd;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Header with Tabs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Artikel Motivasi</h1>
    </div>

    <!-- Search Container -->
    <div class="search-container shadow-sm">
        <form action="{{ route('articles.motivasi') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari artikel motivasi..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </form>
    </div>

    @if($articles->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Belum ada artikel motivasi yang tersedia.
    </div>
    @else
    <div class="row g-4">
        @foreach($articles as $article)
        <div class="col-md-6 col-lg-3">
            <div class="card article-card shadow-sm h-100">
                <div class="article-img-container">
                    @if($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->judul }}" class="article-img">
                    @else
                    <div class="bg-light article-img d-flex align-items-center justify-content-center">
                        <span class="text-muted">No Image</span>
                    </div>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $article->judul }}</h5>
                    <p class="article-date mb-2">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($article->tanggal_terbit)->format('d F Y') }}
                    </p>
                    <p class="card-text article-description flex-grow-1">{{
                        \Illuminate\Support\Str::limit($article->deskripsi, 100) }}</p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary mt-auto">Baca
                        Selengkapnya</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
