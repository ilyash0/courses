@extends('layout')

@section('title', 'Редактирование курса - Админ-панель')

@section('content')
    <div class="header">
        <h1>Редактирование курса</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <img src="{{ asset('assets/img/back.svg') }}" alt="Назад">
            Назад к списку курсов
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @include('courses._form', compact('course'))
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('assets/img/save_course.svg') }}" alt="Изменить">
                        Изменить курс
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
