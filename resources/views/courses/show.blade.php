@extends('layout')

@section('title', 'Курс: ' . $course->name . ' - Админ-панель')

@section('content')
    <div class="header">
        <div>
            <h1>{{ $course->name }}</h1>
            <p class="text-muted mb-0">ID: {{ $course->id }} | Длительность: {{ $course->duration_hours }} часов</p>
        </div>
        <div>
            @if($course->lessons()->count() < 5)
                <a href="{{ route('courses.lessons.create', ['course' => $course->id]) }}" class="btn btn-success me-2">
                    <img src="{{ asset('assets/img/plus.svg') }}" alt="Добавить">
                    Добавить урок
                </a>
            @endif
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                <img src="{{ asset('assets/img/back.svg') }}" alt="Назад">
                Назад к курсам
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Информация о курсе</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p><strong>Описание:</strong> {{ $course->description ?? 'Нет описания' }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Дата начала:</strong> {{ $course?->start_date?->format('d-m-Y') }}</p>
                            <p><strong>Дата окончания:</strong> {{ $course?->end_date?->format('d-m-Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Цена:</strong> {{ number_format($course->price, 2, '.', ' ') }} ₽</p>
                            <p><strong>Количество
                                    уроков:</strong> {{ $course->lessons_count ?? $course->lessons()->count() }} из 5
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        @if($course->cover_image_path)
                            <img src="{{ asset('img/' . $course->cover_image_path) }}" alt="Обложка курса"
                                 class="img-fluid rounded"
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                        @else
                            <p class="text-muted">Изображение отсутствует</p>
                        @endif
                        <p class="mt-2"><small>Обложка курса</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Уроки курса</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Заголовок</th>
                        <th>Длительность (ч)</th>
                        <th>Видео</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($course->lessons as $lesson)
                        <tr>
                            <td>{{ $lesson->id }}</td>
                            <td>{{ $lesson->title }}</td>
                            <td>{{ $lesson->duration_hours }}</td>
                            <td>
                                @if($lesson->video_link)
                                    <span class="badge badge-success">Есть</span>
                                @else
                                    <span class="badge badge-warning">Нет</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}"
                                   class="btn btn-sm btn-primary me-2"
                                   title="Редактировать">
                                    <img src="{{ asset('assets/img/edit.svg') }}" alt="Редактировать"
                                         class="action-icon">
                                </a>
                                <form method="POST"
                                      action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить урок «{{ $lesson->title }}»?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger me-2" title="Удалить">
                                    <img src="{{ asset('assets/img/bug.svg') }}" alt="Удалить" class="action-icon">
                                </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Уроков пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($course->lessons()->count() >= 5)
                <div class="alert alert-warning mt-3">
                    Достигнуто максимальное количество уроков (5). Для добавления нового урока необходимо удалить
                    существующий.
                </div>
            @endif
        </div>
    </div>
@endsection
