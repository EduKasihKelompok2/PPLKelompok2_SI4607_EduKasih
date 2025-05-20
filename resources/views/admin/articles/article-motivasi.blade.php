@extends('layouts.app')
@section('title', 'Kelola Artikel Motivasi')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelola Artikel Motivasi</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addArticleModal">
            <i class="fas fa-plus me-1"></i> Tambah Artikel
        </button>
    </div>

    <!-- Search Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.articles.motivasi') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari artikel..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <!-- Articles Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal Terbit</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $article->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->tanggal_terbit)->format('d F Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($article->image)
                                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->judul }}"
                                        class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="bg-light" style="width: 80px; height: 50px;"></div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#editArticleModal" data-id="{{ $article->id }}"
                                        data-judul="{{ $article->judul }}" data-tanggal="{{ $article->tanggal_terbit }}"
                                        data-deskripsi="{{ $article->deskripsi }}"
                                        data-image="{{ $article->image ? Storage::url($article->image) : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteArticleModal" data-id="{{ $article->id }}"
                                        data-judul="{{ $article->judul }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i> Tidak ada artikel motivasi
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Article Modal -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Tambah Artikel Motivasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="motivasi">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar (Max: 2MB)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Shared Edit Modal -->
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArticleModalLabel">Edit Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editArticleForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="type" value="motivasi">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="edit_tanggal_terbit" name="tanggal_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="5"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Gambar (Max: 2MB)</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                        <div class="mt-2" id="current-image-container">
                            <p>Gambar Saat Ini:</p>
                            <img id="current-image" src="" alt="Current Article Image"
                                style="max-width: 200px; height: auto;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Shared Delete Modal -->
<div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteArticleModalLabel">Hapus Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="delete-confirmation-text">Apakah Anda yakin ingin menghapus artikel ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteArticleForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Edit Modal
        const editModal = document.getElementById('editArticleModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');
            const tanggal = button.getAttribute('data-tanggal');
            const deskripsi = button.getAttribute('data-deskripsi');
            const imageSrc = button.getAttribute('data-image');

            // Set form action URL
            document.getElementById('editArticleForm').action = "{{ route('admin.articles.update', '') }}/" + id;

            // Fill form fields
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_tanggal_terbit').value = tanggal;
            document.getElementById('edit_deskripsi').value = deskripsi;

            // Handle image preview
            const currentImageContainer = document.getElementById('current-image-container');
            const currentImage = document.getElementById('current-image');

            if (imageSrc) {
                currentImage.src = imageSrc;
                currentImageContainer.style.display = 'block';
            } else {
                currentImageContainer.style.display = 'none';
            }
        });

        // Handle Delete Modal
        const deleteModal = document.getElementById('deleteArticleModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');

            // Set form action URL
            document.getElementById('deleteArticleForm').action =`{{ route('admin.articles.destroy', '') }}/` + id;

            // Set confirmation text
            document.getElementById('delete-confirmation-text').textContent = `Apakah Anda yakin ingin menghapus artikel "${judul}"?`;
        });
    });
</script>
@endpush
@endsection