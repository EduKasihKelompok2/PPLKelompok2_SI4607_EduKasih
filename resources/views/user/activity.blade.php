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
                            <button type="submit" class="btn btn-primary" dusk="search-button">Cari</button>
                    </div>
                </form>
            </div>

            @if($activities->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>Belum ada aktivitas yang tercatat.
                </div>
            @else
                @php
                    $activitiesByDate = $activities->groupBy(function($activity) {
                        return \Carbon\Carbon::parse($activity->created_at)->format('Y-m-d');
                    });
                @endphp

                @foreach($activitiesByDate as $date => $groupedActivities)
                    <div class="activity-date-group mb-4">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body p-0">
                                <div class="date-header px-4 py-3 border-bottom">
                                    <h5 class="text-dark mb-0 fw-bold">
                                        {{ \Carbon\Carbon::parse($date)->locale('id')->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                                    </h5>
                                </div>

                                @foreach($groupedActivities as $activity)
                                    <div class="activity-item d-flex justify-content-between align-items-center px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <div class="activity-time me-4">
                                                <span class="fw-medium text-dark">
                                                    {{ \Carbon\Carbon::parse($activity->created_at)->timezone('Asia/Jakarta')->format('H.i') }}
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
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#deleteActivityModal{{ $activity->id }}">
                                                        Hapus dari riwayat
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Modal Delete Activity -->
                                    <div class="modal fade" id="deleteActivityModal{{ $activity->id }}" tabindex="-1"
                                        aria-labelledby="deleteActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('activity.destroy', $activity->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteActivityModalLabel{{ $activity->id }}">Hapus Aktivitas</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus aktivitas ini? Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus Aktivitas</button>
                                                    </div>
                                                </form>
                                            </div>
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

@section('scripts')
<script>
    $(document).ready(function() {
        $("#activitySearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".activity-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });

            $(".activity-date-group").each(function() {
                var visibleItems = $(this).find(".activity-item:visible").length;
                $(this).toggle(visibleItems > 0);
            });
        });
    });
</script>
@endsection
