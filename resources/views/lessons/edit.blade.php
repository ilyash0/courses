@extends('layout')

@section('title', 'Создание курса - Админ-панель')

@section('content')
    <div class="header">
        <h1>Редактирование урока</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <img src="{{ asset('assets/img/back.svg') }}" alt="Назад">
            Назад курсу
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('courses.lessons.update', [$course, $lesson]) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @include('lessons._form', $lesson)
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('assets/img/save_course.svg') }}" alt="Сохранить">
                        Сохранить урок
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
