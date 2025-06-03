@extends('layouts.app')
@section('title', 'Tambah Perguruan Tinggi Baru')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tambah Perguruan Tinggi Baru</h1>
        <a href="{{ route('admin.pencarian-sekolah.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pencarian-sekolah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Info -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Informasi Dasar</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Perguruan Tinggi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="Contoh: Universitas Indonesia" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="" selected disabled>Pilih jenis perguruan tinggi</option>
                            <option value="Perguruan Tinggi Negeri" {{ old('type')=='Perguruan Tinggi Negeri'
                                ? 'selected' : '' }}>Perguruan Tinggi Negeri</option>
                            <option value="Perguruan Tinggi Swasta" {{ old('type')=='Perguruan Tinggi Swasta'
                                ? 'selected' : '' }}>Perguruan Tinggi Swasta</option>
                            <option value="Sekolah Tinggi" {{ old('type')=='Sekolah Tinggi' ? 'selected' : '' }}>Sekolah
                                Tinggi</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="accreditation" class="form-label">Akreditasi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('accreditation') is-invalid @enderror"
                            id="accreditation" name="accreditation" value="{{ old('accreditation') }}"
                            placeholder="Contoh: A" required>
                        @error('accreditation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="founded_year" class="form-label">Tahun Berdiri <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('founded_year') is-invalid @enderror"
                            id="founded_year" name="founded_year" value="{{ old('founded_year') }}"
                            placeholder="Contoh: 1949" required>
                        @error('founded_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="students" class="form-label">Jumlah Mahasiswa <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('students') is-invalid @enderror" id="students"
                            name="students" value="{{ old('students') }}" placeholder="Contoh: ~30,000" required>
                        @error('students')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="Aktif" {{ old('status')=='Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status')=='Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Location Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Lokasi</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">Kota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city') }}" placeholder="Contoh: Depok" required>
                        @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('province') is-invalid @enderror" id="province"
                            name="province" value="{{ old('province') }}" placeholder="Contoh: Jawa Barat" required>
                        @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" rows="2"
                            placeholder="Contoh: Kampus UI Depok, Jawa Barat 16424">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image and Description -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Media & Deskripsi</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Foto Perguruan Tinggi</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        <small class="text-muted">Ukuran yang disarankan: 700x450px. Maksimal 2MB.</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="4"
                            placeholder="Tuliskan deskripsi tentang perguruan tinggi ini...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Informasi Kontak</h5>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website"
                            name="website" value="{{ old('website') }}" placeholder="https://www.universitasanda.ac.id">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                id="instagram" name="instagram" value="{{ old('instagram') }}"
                                placeholder="universitasanda">
                        </div>
                        @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="contact" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                            name="contact" value="{{ old('contact') }}" placeholder="(021) 7867222">
                        @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Faculties Section - Using CKEditor -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Fakultas & Program Studi</h5>
                    </div>

                    <div class="col-12">
                        <div id="facultiesContainer">
                            <!-- Faculty entries will be added here dynamically -->
                        </div>

                        <input type="hidden" name="faculties" id="facultiesJson">

                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-outline-primary" id="addFacultyBtn">
                                <i class="fas fa-plus me-1"></i> Tambah Fakultas
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // Initialize CKEditor for the description field
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });

    // Faculties handling
    document.addEventListener('DOMContentLoaded', function() {
        const facultiesContainer = document.getElementById('facultiesContainer');
        const addFacultyBtn = document.getElementById('addFacultyBtn');
        const facultiesJson = document.getElementById('facultiesJson');

        let facultyCounter = 0;
        let editors = [];

        // Function to create a new faculty entry
        function addFacultyEntry() {
            const facultyId = facultyCounter++;
            const facultyCard = document.createElement('div');
            facultyCard.className = 'card mb-3';
            facultyCard.id = `faculty-${facultyId}`;

            facultyCard.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Fakultas ${facultyCounter}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-faculty"
                            data-faculty-id="${facultyId}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Fakultas</label>
                        <input type="text" class="form-control faculty-name" placeholder="Contoh: Fakultas Teknik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <textarea class="form-control faculty-programs" rows="3"
                                  placeholder="Masukkan satu program studi per baris"></textarea>
                        <small class="text-muted">Contoh: Teknik Informatika, Sistem Informasi, dll.</small>
                    </div>
                </div>
            `;

            facultiesContainer.appendChild(facultyCard);

            // Add event listener for the remove button
            facultyCard.querySelector('.remove-faculty').addEventListener('click', function() {
                const facultyId = this.getAttribute('data-faculty-id');
                removeFacultyEntry(facultyId);
            });

            // Add event listeners to update the JSON data when inputs change
            const nameInput = facultyCard.querySelector('.faculty-name');
            const programsTextarea = facultyCard.querySelector('.faculty-programs');

            nameInput.addEventListener('input', updateFacultiesJson);
            programsTextarea.addEventListener('input', updateFacultiesJson);

            // Initialize CKEditor for programs
            ClassicEditor
                .create(programsTextarea)
                .then(editor => {
                    editors.push({
                        id: facultyId,
                        editor: editor
                    });

                    editor.model.document.on('change:data', () => {
                        updateFacultiesJson();
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Update the JSON representation
            updateFacultiesJson();
        }

        // Function to remove a faculty entry
        function removeFacultyEntry(facultyId) {
            const facultyCard = document.getElementById(`faculty-${facultyId}`);
            if (facultyCard) {
                // Find and destroy editor instance
                const editorIndex = editors.findIndex(e => e.id === parseInt(facultyId));
                if (editorIndex !== -1) {
                    editors[editorIndex].editor.destroy().catch(error => {});
                    editors.splice(editorIndex, 1);
                }

                facultyCard.remove();
                updateFacultiesJson();
            }
        }

        // Function to update the JSON representation of faculties - simpan HTML langsung
        function updateFacultiesJson() {
            const facultyCards = facultiesContainer.querySelectorAll('.card');
            const facultiesData = [];

            facultyCards.forEach(card => {
                const nameInput = card.querySelector('.faculty-name');
                const facultyId = parseInt(card.id.replace('faculty-', ''));

                // Get programs HTML from editor if available
                let programsHtml = '';
                const editorInstance = editors.find(e => e.id === facultyId);

                if (editorInstance) {
                    // Dapatkan HTML content langsung dari CKEditor
                    programsHtml = editorInstance.editor.getData();
                }

                facultiesData.push({
                    name: nameInput.value,
                    programs_html: programsHtml
                });
            });

            facultiesJson.value = JSON.stringify(facultiesData);
        }

        // Set up event listener for add faculty button
        addFacultyBtn.addEventListener('click', addFacultyEntry);

        // Add one faculty entry by default
        addFacultyEntry();
    });
</script>
@endpush
