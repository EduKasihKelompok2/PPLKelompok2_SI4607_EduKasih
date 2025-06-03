<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EduKasih - @yield('title','Page')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #5D5FEF;">
            <div class="container">
                <a class="navbar-brand text-uppercase text-white fw-bold"
                    href="{{ Auth::check() && Auth::user()->hasRole('admin') ? route('admin.home') : route('home') }}">
                    EduKasih
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        {{-- Notification --}}
                        <li class="nav-item dropdown">
                            <a id="notificationDropdown"
                                class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-pre>
                                <i
                                    class="bi bi-bell {{ Auth::user()->unreadNotifications->count() > 0 ? 'text-warning' : '' }}"></i>
                                <span class="badge bg-danger rounded-pill ms-1" id="notificationCount">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown"
                                style="min-width: 350px; max-height: 400px; overflow-y: auto;">
                                <div class="dropdown-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Notifikasi</h6>
                                    @if (Auth::user()->unreadNotifications->count() > 0)
                                    <button class="btn btn-link btn-sm p-0 text-primary" id="markAllReadBtn">
                                        Tandai Semua Dibaca
                                    </button>
                                    @endif
                                </div>
                                <div class="dropdown-divider"></div>
                                <div id="notificationList">
                                    @if (Auth::user()->unreadNotifications->count() > 0)
                                    @foreach (Auth::user()->unreadNotifications->take(5) as $notification)
                                    <div class="dropdown-item notification-item" data-id="{{ $notification->id }}"
                                        style="white-space: normal; cursor: pointer;">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ $notification->data['title'] ?? 'Notifikasi' }}
                                                </div>
                                                <p class="mb-1 text-muted small">{{ $notification->message }}</p>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans()
                                                    }}</small>
                                            </div>
                                            <div class="ms-2">
                                                <span class="badge bg-primary rounded-circle"
                                                    style="width: 8px; height: 8px;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if (Auth::user()->unreadNotifications->count() > 5)
                                    <div class="dropdown-item text-center">
                                        <small class="text-muted">{{ Auth::user()->unreadNotifications->count() - 5 }}
                                            notifikasi lainnya...</small>
                                    </div>
                                    @endif
                                    @else
                                    <div class="dropdown-item text-center">
                                        <div class="py-3">
                                            <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                                            <p class="mb-0 text-muted">Tidak ada notifikasi baru</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        {{-- End Notification --}}

                        <li class="nav-item">
                            <a class="nav-link active text-white d-flex align-items-center"
                                href="{{ Auth::check() && Auth::user()->hasRole('admin') ? route('admin.home') : route('home') }}">
                                <i class="bi bi-house-door me-2 me-lg-0"></i>
                                <span class="d-inline d-lg-none">Home</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white d-flex align-items-center"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                <div class="d-flex flex-column text-start text-lg-end align-items-lg-end me-2">
                                    <div class="fw-bold text-uppercase">{{ Auth::user()->nickname ?? Auth::user()->name
                                        }}</div>
                                    <span style="font-size: 10px;">{{Auth::user()->nisn ?? '-'}}</span>
                                </div>
                                <img src="{{ Auth::user()->photo ? asset('storage/profile_photos/' . Auth::user()->photo) : 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541' }}"
                                    alt="Profile Photo" class="rounded-circle ms-auto" width="40" height="40"
                                    style="object-fit: cover;">
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Content --}}
        <main class="py-4">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-light text-center text-lg-start mt-auto">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © {{ date('Y') }} EduKasih. All rights reserved.
            </div>
        </footer>
    </div>

    <style>
        .navbar-nav .nav-link {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            height: 3rem;
            border-radius: 5px;
        }

        .navbar-nav .nav-link i {
            font-size: 1.25rem;
        }

        .navbar-nav .nav-link:hover {
            background-color: white;
            border-radius: 5px;
            color: #5D5FEF !important;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item {
            border-left: 3px solid #007bff;
        }

        .notification-item.read {
            border-left-color: transparent;
            opacity: 0.7;
        }

        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        #notificationCount {
            display: inline-block;
            transition: all 0.3s ease;
        }

        #notificationCount.hide {
            opacity: 0;
            transform: scale(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Mark individual notification as read
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-id');

                    fetch(`/notification/mark-as-read/${notificationId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mark as read visually
                        this.classList.add('read');
                        this.querySelector('.badge').style.display = 'none';

                        // Update notification count
                        updateNotificationCount();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            // Mark all notifications as read
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    fetch('/notification/mark-all-as-read', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mark all as read visually
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.add('read');
                            const badge = item.querySelector('.badge');
                            if (badge) badge.style.display = 'none';
                        });

                        // Hide mark all read button
                        this.style.display = 'none';

                        // Update notification count to 0
                        const notificationCount = document.getElementById('notificationCount');
                        notificationCount.textContent = '0';
                        notificationCount.classList.add('hide');

                        // Update bell icon
                        const bellIcon = document.querySelector('#notificationDropdown i');
                        bellIcon.classList.remove('text-warning');

                        // Show success message (optional)
                        showNotificationMessage('Semua notifikasi telah ditandai sebagai dibaca');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotificationMessage('Gagal menandai notifikasi', 'error');
                    });
                });
            }

            function updateNotificationCount() {
                const unreadItems = document.querySelectorAll('.notification-item:not(.read)').length;
                const notificationCount = document.getElementById('notificationCount');
                const bellIcon = document.querySelector('#notificationDropdown i');
                const markAllReadBtn = document.getElementById('markAllReadBtn');

                notificationCount.textContent = unreadItems;

                if (unreadItems === 0) {
                    notificationCount.classList.add('hide');
                    bellIcon.classList.remove('text-warning');
                    if (markAllReadBtn) markAllReadBtn.style.display = 'none';
                } else {
                    notificationCount.classList.remove('hide');
                    bellIcon.classList.add('text-warning');
                }
            }

            function showNotificationMessage(message, type = 'success') {
                // Create a toast notification
                const toast = document.createElement('div');
                toast.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                toast.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                document.body.appendChild(toast);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 3000);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>