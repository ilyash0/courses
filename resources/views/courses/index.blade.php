@extends('layout')

@section('title', 'Список курсов - Админ-панель')

@section('content')

    <div class="header">
        <h1>Управление курсами</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-success">
            <img src="{{ asset('assets/img/plus.svg') }}" alt="Добавить">
            Добавить курс
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table course-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Длительность (ч)</th>
                        <th>Цена (₽)</th>
                        <th>Даты</th>
                        <th>Кол-во уроков</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>
                                @if($course->cover_image_path)
                                    <a href="{{ route('courses.show', $course) }}">
                                        <img src="{{ asset('img/' . $course->cover_image_path) }}"
                                             alt="Обложка {{ $course->name }}"
                                             class="img-fluid rounded"
                                             style="max-width: 60px; max-height: 40px; object-fit: cover;">
                                    </a>
                                @else
                                    <span class="text-muted">Нет</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('courses.show', $course) }}" class="text-decoration-none">
                                    {{ $course->name }}
                                </a>
                            </td>
                            <td>{{ $course->duration_hours }}</td>
                            <td>{{ number_format($course->price, 2, '.', ' ') }}</td>
                            <td>{{ $course->start_date->format('d-m-Y') }}
                                — {{ $course->end_date->format('d-m-Y') }}</td>
                            <td>{{ $course->lessons()->count() }}</td>
                            <td>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-primary me-2"
                                   title="Редактировать">
                                    <img src="{{ asset('assets/img/edit.svg') }}" alt="Редактировать">
                                </a>
                                @if($course->lessons()->count() < 1)
                                    <form method="POST" action="{{ route('courses.destroy', $course) }}"
                                          style="display: inline;"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить курс «{{ $course->name }}»?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger me-2" title="Удалить">
                                            <img src="{{ asset('assets/img/bug.svg') }}" alt="Удалить">
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Курсов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $courses->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>

@endsection
