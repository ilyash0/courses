@extends('layout')

@section('title', 'Список студентов - Админ-панель')

@section('content')
    <div class="header">
        <h1>Студенты</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="filter-bar">
                <form method="GET" action="{{ route('students.index') }}" class="filter-bar__form" role="search" aria-label="Фильтр студентов">
                    <div class="filter-bar__left">
                        <label for="course_filter" class="filter-bar__label">Фильтр по курсу</label>
                        <div class="filter-bar__control">
                            <select name="course_filter" id="course_filter" class="filter-bar__select" aria-label="Выбор курса">
                                <option value="">Все курсы</option>
                                @foreach($courses as $courseOption)
                                    <option value="{{ $courseOption->id }}" {{ (string)request('course_filter') === (string)$courseOption->id ? 'selected' : '' }}>
                                        {{ $courseOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-bar__right">
                        <button type="submit" class="btn btn-primary filter-bar__apply" aria-label="Применить фильтр">
                            <svg width="16" height="16" viewBox="0 0 24 24" class="icon icon-filter" aria-hidden="true"><path fill="currentColor" d="M10 18h4v-2h-4v2zm-7-6v2h18v-2H3zm4-6v2h10V6H7z"/></svg>
                            Применить
                        </button>

                        <a href="{{ route('students.index') }}" class="btn btn-outline filter-bar__reset" aria-label="Сбросить фильтр">
                            <svg width="16" height="16" viewBox="0 0 24 24" class="icon icon-reset" aria-hidden="true"><path fill="currentColor" d="M19 13H5v-2h14v2z"/></svg>
                            Сбросить
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Курс</th>
                        <th>Дата записи</th>
                        <th>Статус оплаты</th>
                        <th>Сертификат</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>{{ $order->course->name }}</td>
                            <td>{{ $order->enrollment_date->format('d-m-Y') }}</td>
                            <td>
                                @if($order->payment_status === 'success')
                                    <span class="badge badge-success">оплачено</span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="badge badge-warning">ожидает оплаты</span>
                                @else
                                    <span class="badge badge-danger">ошибка оплаты</span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_status === 'success' && $order->course->lessons->count() > 0)
                                    <a href="" target="_blank" class="btn btn-sm btn-success">
                                        <img src="{{ asset('assets/img/certificate.svg')}}" alt="Скачать сертификат" class="action-icon">
                                        Скачать
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Записей студентов не найдено.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
