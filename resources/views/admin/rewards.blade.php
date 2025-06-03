@extends('layouts.app')
@section('title', 'Rewards')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Please correct the following errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold">Reward Management</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#createRewardModal">
                    <i class="fas fa-plus"></i> Add New Reward
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.rewards') }}">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="search" class="form-label">Search Rewards</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Search by reward name...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.rewards') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Required Badge</th>
                                    <th>File Path</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rewards as $reward)
                                <tr>
                                    <td>{{ $loop->iteration + ($rewards->currentPage() - 1) * $rewards->perPage() }}
                                    </td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ Str::limit($reward->description, 50) }}</td>
                                    <td>
                                        @if($reward->badge)
                                        <span class="badge bg-primary">{{ $reward->badge->name }}</span>
                                        @else
                                        <span class="text-muted">No badge required</span>
                                        @endif
                                    </td>
                                    <td>{{ $reward->file_path ? basename($reward->file_path) : 'No file' }}</td>
                                    <td>{{ $reward->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"
                                            onclick="editReward({{ $reward->id }}, '{{ addslashes($reward->name) }}', '{{ addslashes($reward->description) }}', '{{ $reward->file_path }}', '{{ $reward->badge_id }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteReward({{ $reward->id }}, '{{ addslashes($reward->name) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No rewards found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $rewards->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Reward</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.rewards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="createErrorContainer" class="alert alert-danger d-none" role="alert">
                        <ul id="createErrorList" class="mb-0"></ul>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Reward Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file" required>
                        <small class="text-muted">Upload PDF, DOC, or other relevant files (Required)</small>
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="badge_id" class="form-label">Minimal Badge</label>
                        <select class="form-select @error('badge_id') is-invalid @enderror" id="badge_id"
                            name="badge_id" required>
                            <option value="">Select Badge</option>
                            @foreach($badges as $badge)
                            <option value="{{ $badge->id }}" {{ old('badge_id')==$badge->id ? 'selected' : '' }}>
                                {{ $badge->name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select a badge that must be owned to claim this reward</small>
                        @error('badge_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Reward</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Reward</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editRewardForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div id="editErrorContainer" class="alert alert-danger d-none" role="alert">
                        <ul id="editErrorList" class="mb-0"></ul>
                    </div>

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Reward Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_file" class="form-label">File (Optional)</label>
                        <input type="file" class="form-control" id="edit_file" name="file">
                        <small class="text-muted">Leave empty to keep current file</small>
                        <div id="current_file" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_badge_id_select" class="form-label">Minimal Badge</label>
                        <select class="form-select" id="edit_badge_id_select" name="badge_id" required>
                            <option value="">Select Badge</option>
                            @foreach($badges as $badge)
                            <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select a badge that must be owned to claim this reward</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Reward</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Reward</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the reward "<span id="delete_reward_name"></span>"?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteRewardForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editReward(id, name, description, filePath, requiredBadge) {
        document.getElementById('editErrorContainer').classList.add('d-none');
        document.getElementById('editErrorList').innerHTML = '';

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('editRewardForm').action = `/admin/rewards/${id}`;

        const badgeSelect = document.getElementById('edit_badge_id_select');
        badgeSelect.value = requiredBadge || '';

        const currentFileDiv = document.getElementById('current_file');
        if (filePath && filePath !== 'null') {
            currentFileDiv.innerHTML = `<small class="text-info">Current file: ${filePath}</small>`;
        } else {
            currentFileDiv.innerHTML = '<small class="text-muted">No file uploaded</small>';
        }

        new bootstrap.Modal(document.getElementById('editRewardModal')).show();
    }

    function deleteReward(id, name) {
        document.getElementById('delete_reward_name').textContent = name;
        document.getElementById('deleteRewardForm').action = `/admin/rewards/${id}`;
        new bootstrap.Modal(document.getElementById('deleteRewardModal')).show();
    }

    @if($errors->any() && old('_token'))
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('createRewardModal')).show();
        });
    @endif
</script>

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .btn {
        border-radius: 6px;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endsection