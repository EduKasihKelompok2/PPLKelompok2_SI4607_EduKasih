@extends('layouts.app')
@section('title', 'Kelola Perguruan Tinggi')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelola Perguruan Tinggi</h1>
        <a href="{{ route('admin.pencarian-sekolah.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Perguruan Tinggi
        </a>
    </div>

    <!-- Search Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pencarian-sekolah.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari perguruan tinggi..."
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

    <!-- Schools Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Akreditasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schools as $school)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($school->image)
                                    <img src="{{ Storage::url($school->image) }}" alt="{{ $school->name }}"
                                        class="img-thumbnail me-2"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="bg-light me-2" style="width: 50px; height: 50px;"></div>
                                    @endif
                                    <span>{{ $school->name }}</span>
                                </div>
                            </td>
                            <td>{{ $school->type }}</td>
                            <td>{{ $school->city }}, {{ $school->province }}</td>
                            <td>{{ $school->accreditation }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.pencarian-sekolah.show', $school) }}"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pencarian-sekolah.edit', $school) }}"
                                        class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pencarian-sekolah.destroy', $school) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i> Tidak ada data perguruan tinggi
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $schools->links() }}
            </div>
        </div>
    </div>
</div>
@endsection