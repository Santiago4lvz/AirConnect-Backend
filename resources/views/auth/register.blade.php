@extends('auth.master')

@section('title', trans('auth.REGISTER') . ' - Ipana RestService')

@section('content')
<div class="auth-container">
    <div class="auth-form full-width"> 
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success">Ipana RestService</h3>
            <p class="text-muted">{{ trans('auth.CREATE_ACCOUNT') }}</p>
        </div>

        <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            {{-- Rol por defecto --}}
            <input type="hidden" name="role" value="0">

            <div class="mb-3">
                <label for="name" class="form-label">{{ trans('auth.NAME') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" placeholder="{{ trans('auth.NAME_PLACEHOLDER') }}" 
                       value="{{ old('name') }}" required autofocus aria-describedby="nameHelp">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">{{ trans('auth.LAST_NAME') }}</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                       id="last_name" name="last_name" placeholder="{{ trans('auth.LAST_NAME_PLACEHOLDER') }}" 
                       value="{{ old('last_name') }}" required aria-describedby="lastNameHelp">
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">{{ trans('auth.USERNAME') }}</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror"
                    id="username" name="username" placeholder="{{ trans('auth.USERNAME_PLACEHOLDER') }}"
                    value="{{ old('username') }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="mb-3">
                <label for="email" class="form-label">{{ trans('auth.EMAIL') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="{{ trans('auth.EMAIL_PLACEHOLDER') }}" 
                       value="{{ old('email') }}" required aria-describedby="emailHelp">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 form-password">
                <label for="password" class="form-label">{{ trans('auth.PASSWORD') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="••••••••" required
                       minlength="8" aria-describedby="passwordHelp">
                <span class="password-toggle" data-input="password" onclick="togglePassword('password')">
                    <i class="fas fa-eye"></i>
                </span>
                <small id="passwordHelp" class="form-text text-muted">
                    {{ trans('auth.PASSWORD_REQUIREMENTS') ?? 'Mínimo 8 caracteres' }}
                </small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 form-password">
                <label for="password_confirmation" class="form-label">{{ trans('auth.CONFIRM_PASSWORD') }}</label>
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" placeholder="••••••••" required>
                <span class="password-toggle" data-input="password_confirmation" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                       id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                    <a href="#" class="text-success">{{ trans('auth.TERMS') }}</a>
                </label>
                @error('terms')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success w-100">{{ trans('auth.REGISTER') }}</button>
        </form>
        
        <div class="auth-footer text-center p-4">
            <p class="text-muted mb-0"> {{ trans('auth.ALREADY_REGISTERED') }} 
                <a href="{{ route('login') }}" class="text-success">{{ trans('auth.LOGIN_HERE') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle mostrar/ocultar contraseña
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Validación de contraseñas
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert("{{ trans('auth.PASSWORD_MISMATCH') ?? 'Las contraseñas no coinciden' }}");
        }
    });
</script>
@endpush