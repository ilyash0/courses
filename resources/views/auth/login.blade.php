<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация - Платформа онлайн-обучения</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.ico') }}">
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2><img src="{{ asset('assets/img/learn.svg') }}" alt="Логотип">Платформа обучения</h2>
            <p>Вход в админ-панель</p>
        </div>

        <div class="login-body">
            @error('status')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror

            <form method="POST" action="{{ route('login.send') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           value="{{ old('email') }}"
                           name="email"
                           required>
                    @error('email')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           required>
                    @error('password')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-4">
                    <img src="{{ asset('assets/img/login.svg') }}" alt="Войти">Войти
                </button>

                <div class="text-center mt-3">
                    <small>Демо доступ: admin@edu.com / course2025</small>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
