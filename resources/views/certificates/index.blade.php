@extends('layout')

@section('title', 'Список сертификатов - Админ-панель')

@section('content')
    <div class="header">
        <h1>Сертификаты</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Номер сертификата</th>
                        <th>Студент</th>
                        <th>Email студента</th>
                        <th>Курс</th>
                        <th>Дата выдачи</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->certificate_number }}</td>
                            <td>{{ $certificate->user->name }}</td>
                            <td>{{ $certificate->user->email }}</td>
                            <td>{{ $certificate->course->name }}</td>
                            <td>{{ $certificate->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">Печать</a>
                                <span class="text-muted">-</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Сертификатов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $certificates->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
