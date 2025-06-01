@extends('layouts.app')
@section('title', 'Forum Diskusi')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Forum Header -->
            <div class="card shadow border-0 mb-4 bg-gradient">
                <div class="card-body text-center bg-primary bg-gradient text-white p-5 rounded">
                    <h1 class="display-4 fw-bold">Forum Diskusi</h1>
                    <p class="lead fw-light">Diskusi dan berbagi informasi dengan sesama mahasiswa</p>
                    <div class="mt-4">
                        <button class="btn btn-light btn-lg px-4 shadow-sm" data-bs-toggle="collapse"
                            data-bs-target="#newForumForm">
                            <i class="bi bi-plus-circle me-2"></i> Mulai Diskusi Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0 rounded-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0 rounded-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0 rounded-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Create New Forum Form (Collapsible) -->
            <div class="collapse mb-4" id="newForumForm">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 fw-bold text-primary d-flex align-items-center">
                            <i class="bi bi-pencil-square me-2"></i> Buat Diskusi Baru
                        </h5>
                        <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data"
                            class="forum-form">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title"
                                    placeholder="Judul diskusi..." required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Isi diskusi..." required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="forum_image" class="form-label d-block">Gambar (opsional)</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" class="form-control" id="forum_image" name="image"
                                        accept="image/*">
                                    <div class="image-preview mt-2 d-none">
                                        <div class="position-relative d-inline-block">
                                            <img src="#" class="img-thumbnail preview-img" alt="Preview">
                                            <button type="button"
                                                class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1 m-1 remove-image"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="collapse"
                                    data-bs-target="#newForumForm">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-send me-2"></i> Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-4">
                <form action="{{ route('forum.index') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text border-0 bg-white">
                            <i class="bi bi-search text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-0 shadow-none" placeholder="Cari diskusi..."
                            name="search" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Forum Thread List -->
            @forelse($forums as $forum)
            <div class="card shadow-sm border-0 mb-4 forum-card" id="forum-card-{{ $forum->id }}">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if($forum->user->photo)
                            <img src="{{ asset('storage/profile_photos/' . $forum->user->photo) }}"
                                class="rounded-circle avatar-img" alt="{{ $forum->user->name }}">
                            @else
                            <div
                                class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                                <span class="fw-bold">{{ substr($forum->user->name, 0, 2) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">{{ $forum->user->name }}</h6>

                            <!-- Display user badges -->
                            @if($forum->user->badges && $forum->user->badges->count() > 0)
                            <div class="d-flex gap-1 mt-1">
                                @foreach($forum->user->badges->take(3) as $badge)
                                <img src="{{ Storage::url($badge->icon) }}" alt="{{ $badge->name }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $badge->name }}"
                                    class="badge-icon" width="18" height="18">
                                @endforeach
                                @if($forum->user->badges->count() > 3)
                                <span class="badge rounded-pill bg-light text-dark" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ $forum->user->badges->count() - 3 }} more badges">
                                    +{{ $forum->user->badges->count() - 3 }}
                                </span>
                                @endif
                            </div>
                            @endif

                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>{{ $forum->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if(auth()->id() == $forum->user_id)
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item edit-forum" href="#" data-id="{{ $forum->id }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('forum.destroy', $forum->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-body px-4 py-3">
                    <!-- Forum content -->
                    <div class="forum-content" id="forum-content-{{ $forum->id }}">
                        <h5 class="fw-bold mb-3 text-primary">{{ $forum->title }}</h5>
                        <p class="mb-3 forum-text">{{ $forum->description }}</p>

                        @if($forum->image)
                        <div class="forum-image mt-3 mb-2">
                            <img src="{{ asset('storage/' . $forum->image) }}" class="img-fluid rounded-3"
                                alt="Forum Image">
                        </div>
                        @endif
                    </div>

                    <!-- Edit Forum Form (initially hidden) -->
                    <div class="forum-edit-form d-none" id="forum-edit-{{ $forum->id }}">
                        <form action="{{ route('forum.update', $forum->id) }}" method="POST"
                            enctype="multipart/form-data" class="forum-edit-form-content">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="title" value="{{ $forum->title }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="3"
                                    required>{{ $forum->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                @if($forum->image)
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="mb-3">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $forum->image) }}" class="img-thumbnail"
                                            style="max-height: 150px" alt="Current Image">
                                    </div>
                                </div>
                                @endif
                                <label class="form-label">{{ $forum->image ? 'Ganti Gambar' : 'Tambah Gambar' }}</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2 cancel-edit"
                                    data-id="{{ $forum->id }}">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 px-4 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn btn-link p-0 text-muted toggle-replies-btn"
                                data-id="{{ $forum->id }}">
                                <i class="bi bi-chat-dots me-1"></i>
                                {{ $forum->feedback->count() }} Balasan
                                <i class="bi bi-chevron-down toggle-icon-{{ $forum->id }} ms-1"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm toggle-reply-btn" data-id="{{ $forum->id }}">
                            <i class="bi bi-reply me-1"></i> Balas
                        </button>
                    </div>
                </div>

                <div class="replies-container bg-light px-4 pt-3 pb-4 rounded-bottom d-none"
                    id="replies-container-{{ $forum->id }}">
                    <!-- Reply form -->
                    <div class="reply-form mb-4 d-none" id="reply-form-{{ $forum->id }}">
                        <form action="{{ route('forum.reply', $forum->id) }}" method="POST"
                            enctype="multipart/form-data" class="reply-form-content">
                            @csrf
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/profile_photos/' . auth()->user()->photo) }}"
                                        class="rounded-circle avatar-sm" alt="{{ auth()->user()->name }}">
                                    @else
                                    <div
                                        class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="small fw-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <textarea class="form-control mb-2" rows="2" name="description"
                                        placeholder="Tulis balasan Anda di sini..." required></textarea>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="image-upload-wrapper">
                                            <input type="file" name="image" id="image-{{ $forum->id }}" class="d-none"
                                                accept="image/*">
                                            <label for="image-{{ $forum->id }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-image me-1"></i> Tambah Gambar
                                            </label>
                                            <span class="file-name-{{ $forum->id }} ms-2 small text-muted"></span>

                                            <div class="image-preview mt-2 d-none">
                                                <div class="position-relative d-inline-block">
                                                    <img src="#" class="img-thumbnail preview-img"
                                                        style="max-height: 100px" alt="Preview">
                                                    <button type="button"
                                                        class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1 m-1 remove-reply-image"></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ms-auto">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary me-2 cancel-reply"
                                                data-id="{{ $forum->id }}">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="bi bi-send me-1"></i> Kirim
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Replies Header -->
                    @if($forum->feedback->count() > 0)
                    <h6 class="text-secondary mb-3 fw-bold">Semua Balasan</h6>

                    <!-- List of replies -->
                    <div class="replies-list">
                        @foreach($forum->feedback as $reply)
                        <div class="reply-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    @if($reply->user->photo)
                                    <img src="{{ asset('storage/profile_photos/' . $reply->user->photo) }}"
                                        class="rounded-circle avatar-sm" alt="{{ $reply->user->name }}">
                                    @else
                                    <div
                                        class="avatar-sm bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="small fw-bold">{{ substr($reply->user->name, 0, 2) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="reply-bubble p-3 bg-white rounded-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fw-bold">{{ $reply->user->name }}</h6>

                                            <!-- Display user badges for replies -->
                                            @if($reply->user->badges && $reply->user->badges->count() > 0)
                                            <div class="d-flex gap-1 mt-1">
                                                @foreach($reply->user->badges->take(2) as $badge)
                                                <img src="{{ Storage::url($badge->icon) }}" alt="{{ $badge->name }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $badge->name }}" class="badge-icon" width="16"
                                                    height="16">
                                                @endforeach
                                                @if($reply->user->badges->count() > 2)
                                                <span class="badge rounded-pill bg-light text-dark small-badge"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $reply->user->badges->count() - 2 }} more badges">
                                                    +{{ $reply->user->badges->count() - 2 }}
                                                </span>
                                                @endif
                                            </div>
                                            @endif

                                            <div class="d-flex align-items-center">
                                                <small class="text-muted me-2">{{ $reply->created_at->diffForHumans()
                                                    }}</small>
                                                @if(auth()->id() == $reply->user_id)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm p-0 text-muted" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <li><a class="dropdown-item edit-reply" href="#"
                                                                data-id="{{ $reply->id }}">
                                                                <i class="bi bi-pencil me-2"></i>Edit
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('forum.destroy', $reply->id) }}"
                                                                method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Reply content -->
                                        <div class="reply-content" id="reply-content-{{ $reply->id }}">
                                            <p class="mb-2">{{ $reply->description }}</p>
                                            @if($reply->image)
                                            <img src="{{ asset('storage/' . $reply->image) }}"
                                                class="img-fluid rounded-3 mt-2" style="max-height: 200px;"
                                                alt="Reply Image">
                                            @endif
                                        </div>

                                        <!-- Edit Reply Form (initially hidden) -->
                                        <div class="reply-edit-form d-none" id="reply-edit-{{ $reply->id }}">
                                            <form action="{{ route('forum.update', $reply->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <textarea class="form-control" name="description" rows="2"
                                                        required>{{ $reply->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    @if($reply->image)
                                                    <div class="mb-2">
                                                        <div class="position-relative d-inline-block">
                                                            <img src="{{ asset('storage/' . $reply->image) }}"
                                                                class="img-thumbnail" style="max-height: 100px"
                                                                alt="Current Image">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="form-label">{{ $reply->image ? 'Ganti Gambar' :
                                                            'Tambah Gambar' }}</label>
                                                        <input type="file" name="image"
                                                            class="form-control form-control-sm" accept="image/*">
                                                    </div>
                                                    @else
                                                    <label class="form-label">Tambah Gambar (opsional)</label>
                                                    <input type="file" name="image" class="form-control form-control-sm"
                                                        accept="image/*">
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary me-2 cancel-edit-reply"
                                                        data-id="{{ $reply->id }}">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-check-lg me-1"></i> Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-chat-left-text fs-2 mb-2"></i>
                        <p>Belum ada balasan. Jadilah yang pertama membalas!</p>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="card shadow-sm border-0 text-center p-5">
                <div class="card-body">
                    <i class="bi bi-chat-square-text fs-1 text-muted mb-3"></i>
                    <h5 class="fw-bold">Belum ada diskusi</h5>
                    <p class="text-muted mb-4">Jadilah yang pertama memulai diskusi di forum ini</p>
                    <button class="btn btn-primary px-4" data-bs-toggle="collapse" data-bs-target="#newForumForm">
                        <i class="bi bi-plus-circle me-2"></i> Buat Diskusi Baru
                    </button>
                </div>
            </div>
            @endforelse

            <!-- Pagination -->
            @if(isset($forums) && $forums->hasPages())
            <div class="d-flex justify-content-center mt-4 mb-4">
                <nav aria-label="Forum pagination" class="pagination-nav">
                    {{ $forums->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Base styles */
    body {
        background-color: #f8f9fa;
        color: #444;
    }

    /* Avatar styles */
    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .avatar-img {
        width: 48px;
        height: 48px;
        object-fit: cover;
    }

    /* Badge styles */
    .badge-icon {
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #f0f0f0;
        background-color: #fff;
    }

    .small-badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.4rem;
    }

    /* Tooltip adjustments */
    .tooltip {
        z-index: 10000;
    }

    /* Card styles */
    .card {
        border-radius: 0.85rem;
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .forum-card {
        border-radius: 16px;
    }

    .forum-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }

    .replies-container {
        border-top: 1px solid #eee;

        .reply-item {}

        em;

        .reply-bubble {
            position: relative;
            * Button styles */ border: 1px solid #f0f0f0;

            .btn-primary {
                max-height: 150px;
                610f2;
            }

            6610f2;

            /* Pagination styling */
            .pagination {
                btn-primary:hover {
                    margin-bottom: 0;
                    background-color: #520dc2;
                }

                .pagination .page-link {
                    color: #6610f2;

                    btn-light {
                        border-radius: 0.35rem;
                        background-color: #f8f9fa;
                        margin: 0 2px;
                        ecef;
                    }

                    .pagination .page-item.active .page-link {
                        btn-light:hover {
                            background-color: #6610f2;
                            background-color: #e9ecef;
                            border-color: #6610f2;
                        }

                        /* Dropdown styles */
                        .dropdown-toggle::after {
                            portant;
                            display: none;
                        }

                        .dropdown-menu {
                            border-radius: 0.5rem;
                            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                            border: none;
                            padding: 0.5rem 0;
                        }

                        border-color: rgba(102, 16, 242, 0.4);
                        box-shadow: 0 0 0 0.25rem rgba(102, 16, 242, 0.25);

                        .dropdown-item {
                            padding: 0.5rem 1.25rem;
                        }

                        */ .dropdown-item:hover {
                            background-color: #f8f9fa;
                            object-fit: contain;
                        }
                    }

                    /* Animation for showing/hiding forms */
                    img {
                        .reply-form,
                        ;

                        .forum-edit-form,
                        .reply-edit-form {
                            transition: all 0.3s ease;
                            /* Pagination styling */
                        }

                        margin-bottom: 0;
                    }

                    * Remove image button */ .remove-image,
                    .pagination .page-link {
                        .pagination .page-link {
                            color: #6610f2;
                            border-radius: 0.35rem;
                            margin: 0 2px;
                        }

                        remove-image:hover,
                        .remove-reply-image:hover {
                            .pagination .page-item.active .page-link {
                                active .page-link {
                                    background-color: #6610f2;
                                    border-color: #6610f2;
                                }

                                * Reply count styles */ .reply-count {

                                    /* Dropdown styles */
                                    /* Dropdown styles */
                                    .dropdown-toggle::after {
                                        display: none;
                                    }

                                    /* Alert styling */
                                    .dropdown-menu {
                                        border-radius: 0.5rem;
                                        ;
                                        border-radius: 0.5rem;
                                        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                                        .15);
                                        border: none;
                                        padding: 0.5rem 0;
                                        on styling */ 0;
                                    }

                                    toggle-replies-btn {
                                        color: #6610f2;

                                        .dropdown-item {
                                            ion: none;
                                            padding: 0.5rem 1.25rem;
                                        }

                                        .dropdown-item:hover {
                                            ver {
                                                background-color: #f8f9fa;
                                                8f9fa;
                                            }

                                            /* Animation for showing/hiding forms */
                                            n for showing/hiding forms */ .reply-form,
                                            on: transform 0.3s;

                                            .forum-edit-form,
                                            .reply-edit-form {
                                                transition: all 0.3s ease;
                                                transition: all 0.3s ease;
                                            }

                                            bg-primary {
                                                background-color: #6610f2 !important;

                                                /* Remove image button */
                                                .remove-image,
                                                .remove-reply-image {
                                                    opacity: 0.8;
                                                    lor: rgba(102, 16, 242, 0.15) !important;
                                                }

                                                .remove-image:hover,
                                                ove-image:hover,
                                                .remove-reply-image:hover {
                                                    important;

                                                    .remove-reply-image:hover {
                                                        opacity: 1;
                                                    }

                                                    /* Input field outlines */
                                                    /* Reply count styles */
                                                    Reply count styles */ .reply-count {
                                                        10f2;

                                                        ly-count {
                                                            color: #6c757d;
                                                            6610f2;
                                                            color: #6c757d;
                                                            font-size: 0.9rem;
                                                            9rem;
                                                        }

                                                        .btn-outline-primary:hover {
                                                            /* Alert styling */
                                                            r: #6610f2;

                                                            .alert {
                                                                er-color: #6610f2;
                                                                border-radius: 0.75rem;
                                                                5rem;
                                                            }

                                                            le>@endpush

                                                            /* Toggle replies button styling */
                                                            .toggle-replies-btn {
                                                                color: #6610f2;
                                                                ry -->text-decoration: none;
                                                                ry.com/jquery-3.7.1.min.js"one;
 transition: color 0.2s;
                                                                wRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin=" anonymous"></script>

                                                            }

                                                            < !-- Then include your custom scripts -->.toggle-replies-btn:hover {
                                                                color: #520dc2;

                                                                stener('DOMContentLoaded', function() {}

                                                                    // Check if jQuery is available
                                                                    if (typeof jQuery !=='undefined') {
                                                                        .toggle-icon-transition {
                                                                            transition: transform 0.3s; rds transform 0.3s;
                                                                        }

                                                                        $('.forum-card').addClass('animate__animated animate__fadeIn');
                                                                    }

                                                                    /* Background colors */
                                                                    eplies container visibility .bg-primary {
                                                                        ('.toggle-replies-btn').click(function() {
                                                                                background-color: #6610f2 !important; ata('id');
                                                                            }

                                                                            $(`#replies-container-${forumId}`).toggleClass('d-none');
                                                                            $(`.toggle-icon-${forumId}`).toggleClass('bi-chevron-down bi-chevron-up');

                                                                            .bg-primary-subtle {
                                                                                background-color: rgba(102, 16, 242, 0.15) !important;
                                                                            }

                                                                            // Toggle reply form visibility
                                                                            $('.toggle-reply-btn').click(function() {
                                                                                    .border-primary {
                                                                                        onst forumId=$(this).data('id');
                                                                                        border-color: #6610f2 !important; container is visible firstr: #6610f2 !important;
                                                                                    }

                                                                                    $(`#replies-container-${forumId}`).removeClass('d-none');
                                                                                }

                                                                                $(`.toggle-icon-${forumId}`).removeClass('bi-chevron-down').addClass('bi-chevron-up');

                                                                                /* Input field outlines */
                                                                                ggle reply form .btn-outline-primary {
                                                                                    ply-form-${forumId}`).toggleClass('d-none');

                                                                                color: #6610f2; ( !$(`#reply-form-${forumId}`).hasClass('d-none')) {
                                                                                    border-color: #6610f2; ply-form-${forumId}`).find('textarea').focus();
                                                                            }
                                                                        }
                                                                    });

                                                                .btn-outline-primary:hover {
                                                                    background-color: #6610f2;
                                                                    border-color: #6610f2;
                                                                    ly').click(function() {r: #6610f2;

                                                                }

                                                                const forumId=$(this).data('id');
                                                            }
</style> $('#reply-form-' + forumId).addClass('d-none');
@endpush // Clear the textarea and image preview
$('#reply-form-' + forumId).find('textarea').val('');
@push('scripts') $('#reply-form-' + forumId).find('.image-preview').addClass('d-none');
<!-- First include jQuery -->name-' + forumId).text('');
<script src="https://code.jquery.com/jquery-3.7.1.min.js" ut[type="file" ]').val('');
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Then include your custom scripts -->
<script>
    $('.edit-forum').click(function(e) {
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltipshis).data('id');
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');rumId).addClass('d-none');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));rum-edit-' + forumId).removeClass('d-none');ion() {
        Animation for cards
        // Check if jQuery is available
        if (typeof jQuery !== 'undefined') {                // Cancel edit forum
            $(function() {er visibility
                // Animation for cards
                $('.forum-card').addClass('animate__animated animate__fadeIn');veClass('d-none');

                // Toggle replies container visibility
                $('.toggle-replies-btn').click(function() {
                    const forumId = $(this).data('id');                // Edit reply
                    $(`#replies-container-${forumId}`).toggleClass('d-none');(e) {
                    $(`.toggle-icon-${forumId}`).toggleClass('bi-chevron-down bi-chevron-up');
                });
');
                // Toggle reply form visibilityplies-container-${forumId}`).removeClass('d-none');
                $('.toggle-reply-btn').click(function() {s('bi-chevron-up');
                    const forumId = $(this).data('id');
                    // Make sure replies container is visible first
                    $(`#replies-container-${forumId}`).removeClass('d-none');e')) {
                    $(`.toggle-icon-${forumId}`).removeClass('bi-chevron-down').addClass('bi-chevron-up');
                    // Then toggle reply form('#reply-content-' + replyId).removeClass('d-none');
                    $(`#reply-form-${forumId}`).toggleClass('d-none'); $('#reply-edit-' + replyId).addClass('d-none');
                    if (!$(`#reply-form-${forumId}`).hasClass('d-none')) {                });
                        $(`#reply-form-${forumId}`).find('textarea').focus();
                    }-reply').click(function() {
                });                   const forumId = $(this).data('id');
none');
                // Cancel replyw
                $('.cancel-reply').click(function() {nd('textarea').val('');
                    const forumId = $(this).data('id');.addClass('d-none');
                    $('#reply-form-' + forumId).addClass('d-none');l);
                    // Clear the textarea and image preview);
                    $('#reply-form-' + forumId).find('textarea').val('');                });
                    $('#reply-form-' + forumId).find('.image-preview').addClass('d-none');
                    $('.file-name-' + forumId).text('');r new forum
                    $('#reply-form-' + forumId).find('input[type="file"]').val(''); {
                });

                // Edit forum post-none');
                $('.edit-forum').click(function(e) {oveClass('d-none');
                    e.preventDefault();
                    const forumId = $(this).data('id');                // Image preview for replies
                    $('#forum-content-' + forumId).addClass('d-none');][name="image"]').change(function(e) {
                    $('#forum-edit-' + forumId).removeClass('d-none');
                });                    const forumId = $(this).data('id');
ass('d-none');
                // Cancel edit forum
                $('.cancel-edit').click(function() {
                    const forumId = $(this).data('id');                        // Update image preview in parent form
                    $('#forum-content-' + forumId).removeClass('d-none'); previewDiv = $(this).closest('.image-upload-wrapper').find('.image-preview');eply
                    $('#forum-edit-' + forumId).addClass('d-none');ne');                $('.edit-reply').click(function(e) {
                });('.preview-img').attr('src', url);

                // Edit replyeplyId).addClass('d-none');
                $('.edit-reply').click(function(e) {1]; $('#reply-edit-' + replyId).removeClass('d-none');
                    e.preventDefault();     if (forumId) {                });
                    const replyId = $(this).data('id');                            $('.file-name-' + forumId).text(fileName);
                    $('#reply-content-' + replyId).addClass('d-none');
                    $('#reply-edit-' + replyId).removeClass('d-none');
                });
 me-1"></i> ' + fileName.substring(0, 15) + (fileName.length > 15 ? '...' : ''));'d-none');
                // Cancel edit reply
                $('.cancel-edit-reply').click(function() {
                    const replyId = $(this).data('id');
                    $('#reply-content-' + replyId).removeClass('d-none');
                    $('#reply-edit-' + replyId).addClass('d-none');n(e) {
                }); 0) {
mage-upload-wrapper');
                // Image preview for new forum;   const url = URL.createObjectURL(file);
                $('#forum_image').change(function(e) {e');     $('.image-preview').removeClass('d-none');
                    if (e.target.files.length > 0) {i bi-image me-1"></i> Tambah Gambar');                        $('.preview-img').attr('src', url);
                        const file = e.target.files[0];
                        const url = URL.createObjectURL(file); // Clear file name
                        $('.image-preview').removeClass('d-none');                    const forumId = wrapper.find('input[type="file"]').attr('id').split('-')[1];
                        $('.preview-img').attr('src', url);
                    }t('');emove-image').click(function(e) {
                }););
um_image').val('');
                // Remove image for new forum
                $('.remove-image').click(function(e) {Confirmation before deleting
                    e.preventDefault();                $('.delete-form').submit(function(e) {
                    $('#forum_image').val('');a yakin ingin menghapus?')) {s
                    $('.image-preview').addClass('d-none');
                });

                // Image preview for replies
                $('input[type="file"][name="image"]').change(function(e) {t fileName = file.name;
                    if (e.target.files.length > 0) {                $('textarea').each(function() {
                        const file = e.target.files[0];is.scrollHeight) + 'px;overflow-y:hidden;');               // Update image preview in parent form
                        const url = URL.createObjectURL(file);ad-wrapper').find('.image-preview');
                        const fileName = file.name;     previewDiv.removeClass('d-none');
          previewDiv.find('.preview-img').attr('src', url);
                        // Update image preview in parent form                });
                        const previewDiv = $(this).closest('.image-upload-wrapper').find('.image-preview');
                        previewDiv.removeClass('d-none');
                        previewDiv.find('.preview-img').attr('src', url);

                        // Update file name text
                        const forumId = $(this).attr('id').split('-')[1];
                        if (forumId) {
                            $('.file-name-' + forumId).text(fileName);
                        }});        }            console.error('jQuery is not loaded. Please include jQuery before running this script.');        } else {            });                        // Update file name text
     const forumId = $(this).attr('id').split('-')[1];
                        // Update button label                        if (forumId) {
                        $(this).next('label').html('<i class="bi bi-image me-1"></i> ' + fileName.substring(0, 15) + (fileName.length > 15 ? '...' : ''));name-' + forumId).text(fileName);
                    }
                });

                // Remove reply imagei bi-image me-1"></i> ' + fileName.substring(0, 15) + (fileName.length > 15 ? '...' : ''));
                $('.remove-reply-image').click(function(e) {
                    e.preventDefault();
                    const wrapper = $(this).closest('.image-upload-wrapper');
                    wrapper.find('input[type="file"]').val('');
                    wrapper.find('.image-preview').addClass('d-none');
                    wrapper.find('label').html('<i class="bi bi-image me-1"></i> Tambah Gambar');lt();
upload-wrapper');
                    // Clear file namerapper.find('input[type="file"]').val('');
                    const forumId = wrapper.find('input[type="file"]').attr('id').split('-')[1]; wrapper.find('.image-preview').addClass('d-none');
                    if (forumId) {                    wrapper.find('label').html('<i class="bi bi-image me-1"></i> Tambah Gambar');
                        $('.file-name-' + forumId).text('');
                    }
                });tr('id').split('-')[1];

                // Confirmation before deleting   $('.file-name-' + forumId).text('');
                $('.delete-form').submit(function(e) { }
                    if (!confirm('Apakah Anda yakin ingin menghapus?')) {                });
                        e.preventDefault();
                    }
                });
da yakin ingin menghapus?')) {
                // Auto-resize textarea
                $('textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';// Auto-resize textarea
                    this.style.height = (this.scrollHeight) + 'px';
                });           this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            });         }).on('input', function() {
        } else {           this.style.height = 'auto';
            console.error('jQuery is not loaded. Please include jQuery before running this script.');            this.style.height = (this.scrollHeight) + 'px';
        }                });




@endpush
</script> }); });
} else {
console.error('jQuery is not loaded. Please include jQuery before running this script.');
}
});
</script>
@endpush