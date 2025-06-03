@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> There are some issues with your submission:
                <ul class="mb-0 mt-2 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Profile Header with Avatar -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div id="profilePhotoContainer"
                                        class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                                        style="width: 80px; height: 80px; position: relative; cursor: default;">
                                        <!-- Profile image will be shown here if exists, otherwise default icon -->
                                        <div id="profileImagePreview">
                                            @if(auth()->user()->photo)
                                            <img src="{{ asset('storage/profile_photos/' . auth()->user()->photo) }}"
                                                class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                                            @else
                                            <i class="bi bi-person-fill text-secondary" style="font-size: 2.5rem;"></i>
                                            @endif
                                        </div>

                                        <!-- This overlay will only be visible in edit mode -->
                                        <div id="photoEditOverlay"
                                            class="position-absolute w-100 h-100 rounded-circle d-none">
                                            <div
                                                class="w-100 h-100 rounded-circle bg-dark bg-opacity-50 d-flex justify-content-center align-items-center">
                                                <i class="bi bi-camera text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">{{ auth()->user()->name }}</h5>
                                    <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            {{-- Badges --}}
                            <div>
                                <label for="badge">Badges</label>
                                <div class="d-flex flex-row gap-2">
                                    @if(auth()->user()->badges->count() > 0)
                                        @foreach(auth()->user()->badges as $badge)
                                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 32px; height: 32px;"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ $badge->name }}">
                                                <img src="{{ Storage::url($badge->icon) }}" alt="{{ $badge->name }}"
                                                    class="img-fluid rounded-circle"
                                                    style="width: 24px; height: 24px;">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="toggleEdit"
                                class="btn btn-primary btn-sm rounded-pill px-3">Edit</button>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <form id="profileForm" action="{{route('profile')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Hidden file input for profile photo -->
                        <input type="file" id="profilePhotoInput" name="profile_photo" class="d-none" accept="image/*">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control bg-light"
                                    value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama Panggilan</label>
                                <input type="text" name="nickname" class="form-control bg-light"
                                    value="{{ auth()->user()->nickname ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small text-muted">Jenis Kelamin</label>
                                <select name="gender" class="form-select bg-light" disabled>
                                    <option value="MALE" {{ auth()->user()->gender == 'MALE' ? 'selected' : '' }}>MALE
                                    </option>
                                    <option value="FEMALE" {{ auth()->user()->gender == 'FEMALE' ? 'selected' : ''
                                        }}>FEMALE</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Asal Sekolah</label>
                                <input type="text" name="institution" class="form-control bg-light"
                                    value="{{ auth()->user()->institution ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-muted">NISN</label>
                            <input type="text" name="nisn" class="form-control bg-light"
                                value="{{ auth()->user()->nisn ?? '' }}" readonly>
                        </div>
                        <div id="passwordSection" class="row mb-3 d-none">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small text-muted">New Password</label>
                                <input type="password" name="password" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light"
                                    readonly>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-3">My email Address</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="bg-primary rounded text-white d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px;">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                            <div>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div id="saveButtonContainer" class="text-center mt-4 d-none">
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control:read-only,
    .form-select:disabled {
        background-color: #f8f9fa;
        opacity: 1;
    }

    .form-label {
        margin-bottom: 0.25rem;
    }

    .form-control:not(:read-only),
    .form-select:not(:disabled) {
        background-color: #fff;
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Style for clickable profile photo in edit mode */
    .photo-edit-mode {
        cursor: pointer !important;
        transition: all 0.2s ease;
    }

    .photo-edit-mode:hover #photoEditOverlay {
        display: flex !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const toggleButton = document.getElementById('toggleEdit');
        const formInputs = document.querySelectorAll('#profileForm input, #profileForm select');
        const saveButtonContainer = document.getElementById('saveButtonContainer');
        const profilePhotoContainer = document.getElementById('profilePhotoContainer');
        const photoEditOverlay = document.getElementById('photoEditOverlay');
        const profilePhotoInput = document.getElementById('profilePhotoInput');
        const profileImagePreview = document.getElementById('profileImagePreview');
        const passwordSection = document.getElementById('passwordSection');
        let editMode = false;

        // Store original form values
        const originalValues = {};

        // Save original values of all inputs
        function storeOriginalValues() {
            formInputs.forEach(input => {
                if (input.type !== 'hidden' && input.type !== 'file') {
                    originalValues[input.name] = input.type === 'select-one' ?
                        input.options[input.selectedIndex].value : input.value;
                }
            });

            // Store original profile photo
            originalValues['profilePhoto'] = profileImagePreview.innerHTML;
        }

        // Reset form to original values
        function resetToOriginalValues() {
            formInputs.forEach(input => {
                if (input.type !== 'hidden' && input.type !== 'file' && originalValues[input.name] !== undefined) {
                    if (input.type === 'select-one') {
                        for (let i = 0; i < input.options.length; i++) {
                            if (input.options[i].value === originalValues[input.name]) {
                                input.selectedIndex = i;
                                break;
                            }
                        }
                    } else {
                        input.value = originalValues[input.name];
                    }
                }
            });

            // Reset profile photo
            profileImagePreview.innerHTML = originalValues['profilePhoto'];
            profilePhotoInput.value = ''; // Clear the file input
        }

        // Handle profile photo click in edit mode
        profilePhotoContainer.addEventListener('click', function() {
            if (editMode) {
                profilePhotoInput.click();
            }
        });

        // Handle file selection
        profilePhotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.innerHTML = `<img src="${e.target.result}" class="w-100 h-100 rounded-circle" style="object-fit: cover;">`;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Toggle edit mode
        toggleButton.addEventListener('click', function() {
            if (!editMode) {
                // Entering edit mode - store original values first
                storeOriginalValues();

                // Enable edit mode
                toggleButton.textContent = 'Cancel';
                toggleButton.classList.replace('btn-primary', 'btn-danger');

                // Enable photo editing
                profilePhotoContainer.classList.add('photo-edit-mode');
                photoEditOverlay.classList.remove('d-none');

                // Show password fields
                passwordSection.classList.remove('d-none');

                formInputs.forEach(input => {
                    if (input.type !== 'hidden' && input.type !== 'file') {
                        input.readOnly = false;
                        input.disabled = false;
                        input.classList.remove('bg-light');
                    }
                });

                saveButtonContainer.classList.remove('d-none');
            } else {
                // Exiting edit mode - reset to original values
                resetToOriginalValues();

                // Disable edit mode
                toggleButton.textContent = 'Edit';
                toggleButton.classList.replace('btn-danger', 'btn-primary');

                // Disable photo editing
                profilePhotoContainer.classList.remove('photo-edit-mode');
                photoEditOverlay.classList.add('d-none');

                // Hide password fields
                passwordSection.classList.add('d-none');

                formInputs.forEach(input => {
                    if (input.type !== 'hidden' && input.type !== 'file') {
                        input.readOnly = true;
                        input.disabled = true;
                        input.classList.add('bg-light');
                    }
                });

                saveButtonContainer.classList.add('d-none');
            }

            // Toggle edit mode state
            editMode = !editMode;
        });
    });
</script>
@endsection
