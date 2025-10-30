<!-- Solo para el commit de prueba>
@extends('auth.master')

@section('title', trans('auth.LOGIN') . ' - AirConnect')

@section('content')
<div class="auth-container">
    <div class="auth-image visible"></div>
    <div class="auth-form">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success">AirConnect</h3>
            <p class="text-muted">{{ trans('auth.WELCOME') }}</p>
        </div>

        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ trans('auth.EMAIL') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder={{ trans('passwords.EMAIL_PLACEHOLDER') }} 
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 form-password">
                <label for="password" class="form-label">{{ trans('auth.PASSWORD') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="••••••••" required>
                <span class="password-toggle" data-input="password" onclick="togglePassword('password')">
                    <i class="fas fa-eye"></i>
                </span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success w-100">{{ trans('auth.LOGIN') }}</button>
        </form>
        
        <div class="auth-footer text-center p-4">
            <p class="text-muted mb-0">{{ trans('auth.FORGOT') }} 
                <a href="{{ route('password.request') }}" class="text-success">{{ trans('auth.RECOVER') }}</a>
            </p>
        </div>

        <div class="auth-footer text-center p-4">
            <p class="text-muted mb-0">{{ trans('auth.NO_ACCOUNT') }} 
                <a href="{{ route('register') }}" class="text-success">{{ trans('auth.REGISTER_HERE') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection