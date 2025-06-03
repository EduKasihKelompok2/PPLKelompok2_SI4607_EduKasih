@extends('layouts.app')

@section('title', 'Badge Management')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">Badge Management</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBadgeModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Badge
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error') || $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @if(session('error'))
        {{ session('error') }}
        @endif
        @if($errors->any())
        <ul class="mt-2 mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Achievement Badges</h6>
            <div class="input-group w-50">
                <input type="text" class="form-control" placeholder="Search badges..." id="badgeSearchInput">
                <span class="input-group-text bg-primary text-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="badgeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="15%">Icon</th>
                            <th width="20%">Name</th>
                            <th width="45%">Tugas yang Diperlukan</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($badges->count() > 0)
                        @foreach($badges as $badge)
                        <tr data-name="{{ $badge->name }}" data-requirement="{{ $badge->requirement }}">
                            <td class="text-center">
                                @if($badge->icon)
                                <img src="{{ Storage::url($badge->icon) }}" alt="{{ $badge->name }}" class="badge-icon"
                                    style="max-width: 50px; max-height: 50px;">
                                @else
                                <span class="text-muted">No icon</span>
                                @endif
                            </td>
                            <td>{{ $badge->name }}</td>
                            <td>{{ $badge->requirement }} tugas</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info edit-badge-btn"
                                        data-id="{{ $badge->id }}" data-name="{{ $badge->name }}"
                                        data-requirement="{{ $badge->requirement }}" data-icon="{{ $badge->icon }}"
                                        data-bs-toggle="modal" data-bs-target="#editBadgeModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-badge-btn"
                                        data-id="{{ $badge->id }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteBadgeModal">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">No badges found. Add your first badge.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addBadgeModal" tabindex="-1" aria-labelledby="addBadgeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.badges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addBadgeModalLabel">Add New Badge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Badge Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" required value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="requirement" class="form-label">How many tasks must be completed to earn this
                            badge?</label>
                        <input type="number" min="1" class="form-control @error('requirement') is-invalid @enderror"
                            id="requirement" name="requirement" required value="{{ old('requirement', 1) }}">
                        @error('requirement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Badge Icon (Recommended size: 64x64px)</label>
                        <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon"
                            name="icon" accept="image/*" required>
                        <small class="form-text text-muted">Upload a square image (PNG, JPG, GIF) for best
                            results.</small>
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="icon-preview text-center mt-2" style="display: none;">
                            <p>Preview:</p>
                            <img id="iconPreview" src="#" alt="Icon Preview"
                                style="max-width: 64px; max-height: 64px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Badge</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editBadgeModal" tabindex="-1" aria-labelledby="editBadgeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editBadgeForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBadgeModalLabel">Edit Badge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Badge Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_requirement" class="form-label">How many tasks must be completed to earn this
                            badge?</label>
                        <input type="number" min="1" class="form-control" id="edit_requirement" name="requirement"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_icon" class="form-label">Badge Icon (Recommended size: 64x64px)</label>
                        <input type="file" class="form-control" id="edit_icon" name="icon" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep the current icon.</small>
                    </div>
                    <div class="mb-3">
                        <div class="current-icon text-center mt-2">
                            <p>Current Icon:</p>
                            <img id="currentIconPreview" src="#" alt="Current Icon"
                                style="max-width: 64px; max-height: 64px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                        <div class="new-icon-preview text-center mt-2" style="display: none;">
                            <p>New Icon Preview:</p>
                            <img id="editIconPreview" src="#" alt="New Icon Preview"
                                style="max-width: 64px; max-height: 64px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Badge</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteBadgeModal" tabindex="-1" aria-labelledby="deleteBadgeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteBadgeForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBadgeModalLabel">Delete Badge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this badge? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Badge</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header .input-group {
        max-width: 300px;
    }

    .badge-icon {
        object-fit: contain;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');
        const previewContainer = document.querySelector('.icon-preview');

        iconInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    iconPreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });

        
        const editBtns = document.querySelectorAll('.edit-badge-btn');
        const editIconInput = document.getElementById('edit_icon');
        const editIconPreview = document.getElementById('editIconPreview');
        const currentIconPreview = document.getElementById('currentIconPreview');
        const newIconPreview = document.querySelector('.new-icon-preview');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const requirement = this.getAttribute('data-requirement');
                const icon = this.getAttribute('data-icon');

                document.getElementById('edit_name').value = name;
                document.getElementById('edit_requirement').value = requirement;

                if (icon) {
                    currentIconPreview.src = `/storage/${icon}`;
                } else {
                    currentIconPreview.src = '/images/no-image.png'; // Default placeholder image
                }

                document.getElementById('editBadgeForm').action = `/admin/badges/${id}`;
            });
        });

        editIconInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    editIconPreview.src = e.target.result;
                    newIconPreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                newIconPreview.style.display = 'none';
            }
        });

        
        const deleteBtns = document.querySelectorAll('.delete-badge-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteBadgeForm').action = `/admin/badges/${id}`;
            });
        });

       
        const searchInput = document.getElementById('badgeSearchInput');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#badgeTable tbody tr');

            rows.forEach(row => {
                const name = row.getAttribute('data-name')?.toLowerCase() || '';
                const requirement = row.getAttribute('data-requirement')?.toLowerCase() || '';

                if (name.includes(searchTerm) || requirement.includes(searchTerm) || searchTerm === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush