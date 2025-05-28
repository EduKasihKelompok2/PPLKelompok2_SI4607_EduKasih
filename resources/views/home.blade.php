@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Dashboard</h2>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 text-center">
        @php
        $menus = [
        ['icon' => 'person-circle', 'text' => 'Edit Profil', 'link' => route('profile')],
        ['icon' => 'book', 'text' => 'Daftar Bantuan', 'link' => '#'],
        ['icon' => 'calendar', 'text' => 'Jadwal Belajar', 'link' => route('jadwal-belajar')],
        ['icon' => 'file-earmark-text', 'text' => 'Artikel Pendidikan', 'link' => '#'],
        ['icon' => 'play-circle', 'text' => 'E-Course', 'link' => route('e-course')],
        ['icon' => 'star', 'text' => 'Reward', 'link' => '#'],
        ['icon' => 'search', 'text' => 'Cari Sekolah', 'link' => route('pencarian-sekolah')],
        ['icon' => 'chat-left-dots', 'text' => 'Forum Diskusi', 'link' => '#'],
        ['icon' => 'journal-text', 'text' => 'Bank Soal', 'link' => route('bank-soal')],
        ['icon' => 'lightbulb', 'text' => 'Artikel Motivasi', 'link' => '#'],
        ['icon' => 'question-circle', 'text' => 'FAQ', 'link' => route('faq')],
        ['icon' => 'clock-history', 'text' => 'Riwayat Aktivitas', 'link' => route('activity')],
        ];
        @endphp

        @foreach ($menus as $menu)
        <div class="col">
            <a href="{{$menu['link']}}" class="text-decoration-none">
                <div class="menu-item p-4 border rounded shadow-sm">
                    <i class="bi bi-{{ $menu['icon'] }} fs-1"></i>
                    <p class="mt-2 fw-semibold">{{ $menu['text'] }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
    .menu-item {
        transition: all 0.3s ease-in-out;
    }

    .menu-item:hover {
        background-color: #0d6efd;
        /* Bootstrap Primary Blue */
        color: white;
        border-color: #0d6efd;
    }

    .menu-item:hover i {
        color: white;
    }

    /* Tambahan: Buat grid lebih rapi untuk layar besar */
    @media (min-width: 1400px) {
        .row-cols-lg-4 {
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedback = document.getElementById('login-feedback');
        if (feedback) {
            setTimeout(() => {
                feedback.style.display = 'none';
            }, 3000);
        }
    });
</script>
@endsection