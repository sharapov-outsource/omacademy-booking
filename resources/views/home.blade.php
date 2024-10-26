<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <h1>Мои бронирования</h1>

        @if($bookings->isEmpty())
            <p>У вас нет активных бронирований.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Машина</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->car->name }}</td>
                        <td>{{ $booking->booking_start_date }}</td>
                        <td>{{ $booking->booking_end_date }}</td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <h2>Новое бронирование</h2>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="car_id">Машина</label>
                <select name="car_id" id="car_id" class="form-control" required>
                    <option value="">Выберите машину</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="booking_start_date">Дата начала бронирования</label>
                <input type="datetime-local" name="booking_start_date" id="booking_start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="booking_end_date">Дата окончания бронирования</label>
                <input type="datetime-local" name="booking_end_date" id="booking_end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Забронировать</button>
        </form>

    </div>
@endsection
