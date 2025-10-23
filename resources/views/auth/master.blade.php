<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ipana RestService')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--bs-body-bg);
        }
        .auth-container {
            display: flex;
            width: 900px;
            max-width: 100%;
            background: var(--bs-body-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .auth-image {
            flex: 1;
            background: url('https://laravel.com/img/logomark.min.svg') no-repeat center center/cover;
            display: none; 
        }
        .auth-image.visible {
            display: block; 
        }
        .auth-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .auth-form.full-width {
            flex: 2; 
        }
        .theme-toggle {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .form-password {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            color: #6c757d;
        }
    </style>
    
    @stack('styles')
</head>
<body>

<!-- Botón de cambio de tema -->
<div class="theme-toggle">
    <button id="toggleTheme" class="btn btn-outline-secondary btn-sm">🌙 {{ trans('forms.DARK_MODE') }}</button>
</div>
<div class="language-selector" style="position: absolute; top: 15px; left: 15px;">
    <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{ strtoupper(app()->getLocale()) }}
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('language.switch', 'es') }}">ES - {{ trans('forms.SPANISH') }}</a></li>
            <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">EN - {{ trans('forms.ENGLISH') }}</a></li>
        </ul>
    </div>
</div>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Al cargar la página, verificar si hay una preferencia de tema guardada
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        const html = document.documentElement;
        const toggleTheme = document.getElementById('toggleTheme');
        
        if (savedTheme) {
            html.setAttribute('data-bs-theme', savedTheme);
            toggleTheme.textContent = savedTheme === 'dark' ? '☀️ {{ trans('forms.LIGHT_MODE') }}' : '🌙 {{ trans('forms.DARK_MODE') }}';
        } else {
            // Si no hay preferencia guardada, usar la preferencia del sistema
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                html.setAttribute('data-bs-theme', 'dark');
                toggleTheme.textContent = '☀️ {{ trans('forms.LIGHT_MODE') }}';
                localStorage.setItem('theme', 'dark');
            }
        }
    });

    // Función para cambiar entre tema claro y oscuro
    const toggleTheme = document.getElementById('toggleTheme');
    const html = document.documentElement;

    toggleTheme.addEventListener('click', () => {
        const currentTheme = html.getAttribute('data-bs-theme');
        if (currentTheme === 'light') {
            html.setAttribute('data-bs-theme', 'dark');
            toggleTheme.textContent = '☀️ {{ trans('forms.LIGHT_MODE') }}';
            localStorage.setItem('theme', 'dark');
        } else {
            html.setAttribute('data-bs-theme', 'light');
            toggleTheme.textContent = '🌙 {{ trans('forms.DARK_MODE') }}';
            localStorage.setItem('theme', 'light');
        }
    });

    // Función para mostrar/ocultar contraseña (común para todas las vistas de auth)
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.querySelector(`[data-input="${inputId}"] i`);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

@stack('scripts')
</body>
</html>