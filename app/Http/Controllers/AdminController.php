<?php
/**
 * @copyright Alexander S. <alexander@sharapov.biz>
 * @link http://www.sharapov.biz/
 * @link https://golance.com/freelancer/alexander.sharapov
 * @link https://www.upwork.com/freelancers/sharapov
 * Date: 26.10.2024
 * Time: 18:23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('car', 'user')->get();

        return view('admin.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'statuses' => 'required|array',
            'statuses.*' => 'in:Новое,Подтверждено,Отменено',
        ]);

        foreach ($validated['statuses'] as $bookingId => $status) {
            $booking = Booking::findOrFail($bookingId);
            $booking->status = $status;
            $booking->save();
        }

        return redirect()->route('bookings.index')->with('status', 'Статусы успешно обновлены.');
    }
}
