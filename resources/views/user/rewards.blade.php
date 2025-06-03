@extends('layouts.app')
@section('title', 'Rewards')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary fw-bold mb-1">Available Rewards</h2>
                    <p class="text-muted">Claim rewards by earning the required badges!</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('user.rewards') }}">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="search" class="form-label">Search Rewards</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by reward name or description...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('user.rewards') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                @forelse($rewards as $reward)
                @php
                $canClaim = !$reward->badge_id || $userHighestBadgeId >= $reward->badge_id;
                $alreadyClaimed = in_array($reward->id, $claimedRewards);
                $cardClass = !$canClaim ? 'reward-disabled' : '';
                @endphp

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm reward-card {{ $cardClass }}"
                        style="background-color: {{ $canClaim ? '#e8f2ff' : '#f8f9fa' }};">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-gift text-primary"
                                    style="font-size: 2rem; opacity: {{ $canClaim ? '1' : '0.5' }};"></i>
                            </div>

                            <h6 class="card-title fw-bold mb-2" style="color: {{ $canClaim ? '#000' : '#6c757d' }};">
                                {{ $reward->name }}
                            </h6>

                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($reward->description, 80) }}
                            </p>

                            @if($reward->badge)
                            <div class="mb-3">
                                <small class="text-muted d-block">Required Badge Level:</small>
                                <span class="badge {{ $canClaim ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $reward->badge->name }} (Level {{ $reward->badge_id }})
                                </span>
                                @if($userHighestBadgeId > 0)
                                <div class="mt-1">
                                    <small class="text-info">Your Level: {{ $userHighestBadgeId }}</small>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($reward->file_path)
                            <div class="mb-3">
                                <small class="text-info">
                                    <i class="fas fa-paperclip"></i> File included
                                </small>
                            </div>
                            @endif

                            @if($alreadyClaimed)
                            @if($reward->file_path)
                            <a href="{{ route('user.rewards.download', $reward->id) }}" class="btn btn-success px-4">
                                <i class="fas fa-download"></i> DOWNLOAD
                            </a>
                            @else
                            <button class="btn btn-success px-4" disabled>
                                <i class="fas fa-check"></i> CLAIMED
                            </button>
                            @endif
                            @elseif($canClaim)
                            <form method="POST" action="{{ route('user.rewards.claim', $reward->id) }}"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary px-4"
                                    onclick="return confirm('Are you sure you want to claim this reward?')">
                                    <i class="fas fa-download"></i> CLAIM
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary px-4" disabled>
                                <i class="fas fa-lock"></i> NEED LEVEL {{ $reward->badge_id }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-gift text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">No rewards available</h4>
                        <p class="text-muted">Check back later for new rewards!</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if($rewards->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $rewards->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .reward-card {
        transition: all 0.3s ease-in-out;
    }

    .reward-card:not(.reward-disabled):hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .reward-disabled {
        opacity: 0.7;
    }

    .reward-disabled .card-body {
        filter: grayscale(50%);
    }

    .btn-primary {
        background: linear-gradient(135deg, #6f42c1 0%, #5a67d8 100%);
        border: none;
        border-radius: 25px;
        font-weight: bold;
        padding: 8px 30px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a2d91 0%, #4c63d2 100%);
        transform: scale(1.05);
    }

    .btn-success {
        border-radius: 25px;
        font-weight: bold;
        padding: 8px 30px;
    }

    .btn-secondary {
        border-radius: 25px;
        font-weight: bold;
        padding: 8px 30px;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection