@extends('layout')

@section('title', 'Создание курса - Админ-панель')

@section('content')
    <div class="header">
    <h1>Создание курса</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        <img src="{{ asset('assets/img/back.svg') }}" alt="Назад">
        Назад к списку курсов
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
            @csrf
            @include('courses._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('assets/img/save_course.svg') }}" alt="Сохранить">
                    Создать курс
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection
