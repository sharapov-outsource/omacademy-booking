<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();

        $cars = Car::all();

        return view('home', compact('bookings', 'cars'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'booking_start_date' => 'required|date',
            'booking_end_date' => 'required|date|after:booking_start_date',
        ]);

        $existingBooking = Booking::where('car_id', $request->input('car_id'))
            ->where(function ($query) use ($request) {
                $query->whereBetween('booking_start_date', [$request->input('booking_start_date'), $request->input('booking_end_date')])
                    ->orWhereBetween('booking_end_date', [$request->input('booking_start_date'), $request->input('booking_end_date')])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('booking_start_date', '<=', $request->input('booking_start_date'))
                            ->where('booking_end_date', '>=', $request->input('booking_end_date'));
                    });
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->route('home')->withErrors('Это время уже забронировано для выбранной машины.');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $request->input('car_id'),
            'booking_start_date' => $request->input('booking_start_date'),
            'booking_end_date' => $request->input('booking_end_date'),
            'status' => 'Новое',
        ]);

        return redirect()->route('home')->with('success', 'Бронирование успешно создано!');
    }
}
