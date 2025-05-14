@extends('layouts.app')
@section('title', 'Daftar Bantuan Beasiswa')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">Daftar Bantuan</h1>
            <p class="text-muted">Informasi beasiswa dan bantuan pendidikan yang tersedia untuk mahasiswa</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari beasiswa..."
                            autocomplete="off">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-outline-primary active" data-filter="all">Semua</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="active">Periode Aktif</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="academic">Akademik</button>
                <button class="btn btn-sm btn-outline-primary" data-filter="financial">Finansial</button>
            </div>
        </div>
    </div>

    <!-- Scholarships Grid -->
    <div class="row" id="scholarshipsContainer">
        <!-- Scholarship 1 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="/api/placeholder/800/400" class="card-img-top" height="200" alt="Beasiswa 1">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="card-title">BEASISWA 1</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <span>17 Agustus 2025 - 15 September 2025</span>
                        </div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="badge bg-light text-dark me-1">Sarjana</span>
                                <span class="badge bg-light text-dark">Full Coverage</span>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="showScholarshipDetail(1)">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
