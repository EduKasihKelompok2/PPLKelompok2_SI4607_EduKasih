@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="p-4 rounded" style="background-color: #b9b7fa;">
                        <h2 class="mb-4 fw-bold">Registrasi</h2>

                        <form method="POST" action="{{ route('register') }}"
                            x-data="{ showPassword: false, showConfirmPassword: false, password: '', confirmPassword: '', passwordMatch: true }">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror"
                                    name="dob" value="{{ old('dob') }}" required>
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" class="form-select @error('gender') is-invalid @enderror"
                                    name="gender" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- School/Institution -->
                            <div class="mb-3">
                                <label for="institution" class="form-label">School/Institution</label>
                                <input id="institution" type="text"
                                    class="form-control @error('institution') is-invalid @enderror" name="institution"
                                    value="{{ old('institution') }}" required>
                                @error('institution')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
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
                                        required autocomplete="new-password" x-model="password"
                                        @input="passwordMatch = (password === confirmPassword) || confirmPassword === ''"
                                        aria-describedby="passwordFeedback">
                                    <button class="btn btn-outline-secondary" type="button"
                                        @click="showPassword = !showPassword">
                                        <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">Re-Password</label>
                                <div class="input-group">
                                    <input id="password-confirm" :type="showConfirmPassword ? 'text' : 'password'"
                                        class="form-control"
                                        :class="{ 'is-invalid': !passwordMatch && confirmPassword !== '' }"
                                        name="password_confirmation" required autocomplete="new-password"
                                        x-model="confirmPassword"
                                        @input="passwordMatch = (password === confirmPassword)"
                                        aria-describedby="confirmPasswordFeedback">
                                    <button class="btn btn-outline-secondary" type="button"
                                        @click="showConfirmPassword = !showConfirmPassword">
                                        <i class="bi" :class="showConfirmPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>
                                <!-- Custom error message that uses Bootstrap styling but Alpine.js for display logic -->
                                <div class="invalid-feedback" id="confirmPasswordFeedback"
                                    :class="{ 'd-block': !passwordMatch && confirmPassword !== '' }">
                                    Passwords do not match
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"
                                    :disabled="!passwordMatch && confirmPassword !== ''">
                                    Sign Up
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <p>Already have an account? <a href="{{ route('login') }}"
                                        class="text-decoration-none">Login here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection