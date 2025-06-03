@extends('layouts.app')

@section('title', $article->judul)

@push('styles')
<style>
    .article-header {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .article-title {
        font-weight: 700;
        color: #212529;
    }

    .article-date {
        color: #6c757d;
        font-size: 1rem;
    }

    .article-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .article-content {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-badge {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
    }

    .badge-motivasi {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-pendidikan {
        background-color: #d4edda;
        color: #155724;
    }

    .img-container {
        position: relative;
        height: 100%;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ $article->type == 'motivasi' ? route('articles.motivasi') : route('articles.pendidikan') }}"
            class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Article Header - 2 Column Grid -->
    <div class="card article-header shadow-sm">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Left Column - Article Title and Date -->
                <div class="col-md-6 p-4 p-md-5">
                    <div class="mb-3">
                        <span
                            class="article-badge {{ $article->type == 'motivasi' ? 'badge-motivasi' : 'badge-pendidikan' }}">
                            {{ $article->type == 'motivasi' ? 'Artikel Motivasi' : 'Artikel Pendidikan' }}
                        </span>
                    </div>
                    <h1 class="article-title mb-4">{{ $article->judul }}</h1>
                    <p class="article-date">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ \Carbon\Carbon::parse($article->tanggal_terbit)->format('d F Y') }}
                    </p>
                </div>

                <!-- Right Column - Article Image -->
                <div class="col-md-6">
                    <div class="img-container">
                        @if($article->image)
                        <img src="{{ Storage::url($article->image) }}" class="article-image"
                            alt="{{ $article->judul }}">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                            style="width: 100%; height: 100%; min-height: 250px; border-radius: 8px;">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="article-content shadow-sm">
        {!! nl2br(e($article->deskripsi)) !!}
    </div>

    <!-- Share Buttons -->
    <div class="mt-4 text-center">
        <p class="mb-2">Bagikan artikel ini:</p>
        <div class="d-inline-flex gap-2">
            <a href="#" class="btn btn-outline-primary">
                <i class="fab fa-facebook-f me-2"></i>Facebook
            </a>
            <a href="#" class="btn btn-outline-info">
                <i class="fab fa-twitter me-2"></i>Twitter
            </a>
            <a href="#" class="btn btn-outline-success">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection