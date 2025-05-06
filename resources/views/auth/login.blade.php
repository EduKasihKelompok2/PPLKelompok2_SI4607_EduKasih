@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="p-4 rounded" style="background-color: #b9b7fa;">
                        <h2 class="mb-4 fw-bold">Login</h2>

                        <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    aria-describedby="emailFeedback" autofocus>
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert" id="emailFeedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input id="password" :type="showPassword ? 'text' : 'password'"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" aria-describedby="passwordFeedback">
                                    <button class="btn btn-outline-secondary" type="button"
                                        @click="showPassword = !showPassword">
                                        <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block" id="passwordFeedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                    old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-3">
                                <button dusk="login-button" type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>

                            <!-- Forgot Password -->
                            @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                            @endif

                            <!-- Register Link -->
                            <div class="text-center mt-3">
                                <p>Don't have an account? <a href="{{ route('register') }}"
                                        class="text-decoration-none">Register here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection