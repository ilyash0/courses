@extends('layout')

@section('title', 'Список студентов - Админ-панель')

@section('content')
    <div class="header">
        <h1>Студенты</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Обернем форму в отдельный блок для лучшего отображения -->
            <div class="filter-section mb-4">
                <form method="GET" action="{{ route('students.index') }}" class="d-flex flex-wrap align-items-end gap-3">
                    <div class="flex-grow-1 min-width-select">
                        <label for="course_filter" class="form-label fw-bold">Фильтр по курсу</label>
                        <select name="course_filter" id="course_filter" class="form-select custom-select">
                            <option value="">Все курсы</option>
                            @foreach($courses as $courseOption)
                                <option value="{{ $courseOption->id }}" {{ request('course_filter') == $courseOption->id ? 'selected' : '' }}>
                                    {{ $courseOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Применить
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary w-100 mt-2">
                            <i class="fas fa-times me-1"></i> Сбросить
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
                        <th>Действия</th>
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
                                        <img src="{{ asset('assets/img/certificate.svg')}}" alt="Сертификат" class="action-icon">
                                        Сертификат
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

            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
