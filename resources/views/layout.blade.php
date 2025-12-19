<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель - Платформа онлайн-обучения')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.ico') }}">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>
            Админ-панель
        </h2>
    </div>

    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">
                <img src="{{ asset('assets/img/learn.svg') }}" alt="Курсы">
                Курсы
            </a>
        </li>
        <li>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                <img src="{{ asset('assets/img/student.svg') }}" alt="Студенты">
                Студенты
            </a>
        </li>
        <li>
            <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                <img src="{{ asset('assets/img/certificate.svg') }}" alt="Сертификаты">
                Сертификаты
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                <img src="{{ asset('assets/img/exit.svg') }}" alt="Выйти">
                Выйти
            </a>
        </li>
    </ul>
</div>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
