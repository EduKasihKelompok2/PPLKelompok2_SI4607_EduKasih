@extends('layouts.app')
@section('title', 'Riwayat Aktivitas')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Search Bar -->
            <div class="search-container mb-4">
                <form action="{{ route('activity') }}" method="GET">
                    <div class="input-group rounded-pill shadow-sm border overflow-hidden">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="activitySearch" class="form-control border-0 shadow-none"
                            placeholder="Telusuri riwayat aktivitas..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            @if($activities->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>Belum ada aktivitas yang tercatat.
            </div>
            @else
            <!-- Group activities by date -->
            @php
            $activitiesByDate = $activities->groupBy(function($activity) {
            return \Carbon\Carbon::parse($activity->created_at)->format('Y-m-d');
            });
            @endphp

            @foreach($activitiesByDate as $date => $groupedActivities)
            <div class="activity-date-group mb-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-0">
                        <!-- Date Header -->
                        <div class="date-header px-4 py-3 border-bottom">
                            <h5 class="text-dark mb-0 fw-bold">
                                {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </h5>
                        </div>

                        <!-- Activity Items -->
                        @foreach($groupedActivities as $activity)
                        <div class="activity-item d-flex justify-content-between align-items-center px-4 py-3
                                        {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="activity-time me-4">
                                    <span class="fw-medium text-dark">
                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('H.i') }}
                                    </span>
                                </div>
                                <div class="activity-description">
                                    <span class="text-dark">{{ $activity->description }}</span>
                                </div>
                            </div>
                            <div class="activity-action">
                                <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('activity.destroy', $activity->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')">
                                                Hapus dari riwayat
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $activities->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }

    .search-container .input-group {
        height: 58px;
        background-color: #ffffff;
    }

    .search-container .form-control {
        font-size: 16px;
    }

    .search-container .input-group-text {
        font-size: 18px;
    }

    .card {
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .date-header {
        background-color: #ffffff;
    }

    .activity-item {
        background-color: #ffffff;
        transition: background-color 0.2s ease;
    }

    .activity-item:hover {
        background-color: #f8f9fa;
    }

    .activity-time {
        min-width: 60px;
    }

    .rounded-4 {
        border-radius: 12px;
    }

    .dropdown-menu {
        min-width: 200px;
        padding: 8px 0;
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        padding: 8px 16px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 767px) {
        .search-container .input-group {
            height: 50px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Script untuk pencarian aktivitas
    $(document).ready(function() {
        $(".search-container input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".activity-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            // Sembunyikan grup tanggal jika semua aktivitas di dalamnya tersembunyi
            $(".activity-date-group").each(function() {
                var visibleItems = $(this).find(".activity-item:visible").length;
                $(this).toggle(visibleItems > 0);
            });
        });
    });
</script>
@endsection
