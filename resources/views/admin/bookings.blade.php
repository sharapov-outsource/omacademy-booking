<!-- resources/views/admin/bookings.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Все бронирования</h1>

        @if($bookings->isEmpty())
            <p>Нет активных бронирований.</p>
        @else
            <form method="POST" action="{{ route('bookings.updateStatus') }}">
                @csrf
                @method('PATCH')
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Машина</th>
                        <th>Дата начала</th>
                        <th>Дата окончания</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->user->email }}</td>
                            <td>{{ $booking->user->phone }}</td>
                            <td>{{ $booking->car->name }}</td>
                            <td>{{ $booking->booking_start_date }}</td>
                            <td>{{ $booking->booking_end_date }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                @if($booking->status == 'Новое')
                                    <select class="form-control" name="statuses[{{ $booking->id }}]">
                                        <option value="Новое" selected>Новое</option>
                                        <option value="Подтверждено">Подтверждено</option>
                                        <option value="Отменено">Отменено</option>
                                    </select>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>
        @endif
    </div>
@endsection
