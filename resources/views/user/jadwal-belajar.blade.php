@extends('layouts.app')

@section('title', 'Jadwal Belajar')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Jadwal Belajar</h2>
        <button type="button" class="btn btn-primary rounded-circle shadow" data-bs-toggle="modal"
            data-bs-target="#addScheduleModal" style="width: 50px; height: 50px;">
            <i class="bi bi-plus fs-4"></i>
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($datas->isEmpty())
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
        <h4>Tidak ada jadwal belajar</h4>
        <p class="mb-0">Klik tombol + untuk menambahkan jadwal belajar baru.</p>
    </div>
    @else
    @foreach($groupedJadwals as $day => $jadwals)
    <div class="mb-4">
        <div class="day-header d-flex align-items-center bg-light rounded pb-2">
            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                style="width:40px; height:40px;">
                <i class="bi bi-calendar-week text-primary fs-4"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $day }}</h3>
        </div>

        <div class="d-flex overflow-x-auto py-3" style="gap: 1rem;">
            @foreach($jadwals as $jadwal)
            <div class="card border-0 shadow-sm flex-shrink-0" style="width: 400px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width:40px; height:40px;">
                            <i class="bi bi-book text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">{{ $jadwal->nama_mapel }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 120px;">
                                        <i class="bi bi-clock me-1"></i> Waktu
                                    </th>
                                    <td class="fw-medium">{{ $jadwal->jam }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted" style="width: 120px;">
                                        <i class="bi bi-info-circle me-1"></i> Keterangan
                                    </th>
                                    <td class="fw-medium">{{ $jadwal->keterangan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex mt-3">
                        <button class="btn btn-primary btn-sm me-2 btn-edit" data-id="{{ $jadwal->id }}"
                            data-nama="{{ $jadwal->nama_mapel }}" data-jam="{{ $jadwal->jam }}"
                            data-hari="{{ $jadwal->hari }}" data-keterangan="{{ $jadwal->keterangan }}">
                            <i class="bi bi-pencil me-1"></i> EDIT
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $jadwal->id }}"
                            data-nama="{{ $jadwal->nama_mapel }}" data-jam="{{ $jadwal->jam }}"
                            data-hari="{{ $jadwal->hari }}">
                            <i class="bi bi-trash me-1"></i> HAPUS
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    @endif
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="addScheduleModalLabel">Tambah Jadwal Belajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" action="{{ url('/jadwal-belajar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Nama Pelajaran</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                            <select class="form-select" id="nama_mapel" name="nama_mapel" required>
                                <option value="" disabled selected>Pilih mata pelajaran</option>
                                <option value="Fisika">Fisika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Geografi">Geografi</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosiologi">Sosiologi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="jam" class="form-label">Waktu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input type="time" class="form-control" id="jam" name="jam" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="hari" class="form-label">Hari</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <select class="form-select" id="hari" name="hari" required>
                                    <option value="" disabled selected>Pilih hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Masukkan keterangan kegiatan"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="scheduleForm" class="btn btn-primary px-4">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal (Single reusable modal) -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="editScheduleModalLabel">Edit Jadwal Belajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_nama_mapel" class="form-label">Nama Pelajaran</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                            <select class="form-select" id="edit_nama_mapel" name="nama_mapel" required>
                                <option value="Fisika">Fisika</option>
                                <option value="Kimia">Kimia</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Biologi">Biologi</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Geografi">Geografi</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosiologi">Sosiologi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="edit_jam" class="form-label">Waktu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input type="time" class="form-control" id="edit_jam" name="jam" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_hari" class="form-label">Hari</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <select class="form-select" id="edit_hari" name="hari" required>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"
                                placeholder="Masukkan keterangan kegiatan"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="editScheduleForm" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>


@push('styles')
<style>
    /* Card hover effect */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    /* Button styles */
    .btn {
        border-radius: 4px;
        transition: all 0.2s;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    /* Custom icons for different subjects */
    .schedule-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Modal animation */
    .modal .modal-content {
        border-radius: 10px;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
    }

    /* Input focus states */
    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Edit button click handler
        const editButtons = document.querySelectorAll('.btn-edit');
        const editModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const jam = this.getAttribute('data-jam');
                const hari = this.getAttribute('data-hari');
                const keterangan = this.getAttribute('data-keterangan');

                // Set form action URL
                document.getElementById('editScheduleForm').action = `/jadwal-belajar/${id}`;

                // Fill form fields
                document.getElementById('edit_nama_mapel').value = nama;
                document.getElementById('edit_jam').value = jam;
                document.getElementById('edit_hari').value = hari;
                document.getElementById('edit_keterangan').value = keterangan;

                // Show modal using Bootstrap's API
                editModal.show();
            });
        });
    });
</script>
@endpush

@endsection