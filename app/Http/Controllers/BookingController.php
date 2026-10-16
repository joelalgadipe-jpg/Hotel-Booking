<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with('room')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests'    => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($data['room_id']);

        if ($room->status !== 'available') {
            return back()->withInput()->with('error', 'This room is not available.');
        }

        if ($data['guests'] > $room->capacity) {
            return back()->withInput()->with('error', 'The number of guests exceeds the room capacity.');
        }

        if (!$room->isAvailableBetween($data['check_in'], $data['check_out'])) {
            return back()->withInput()->with('error', 'This room is already booked for those dates. Please choose different dates.');
        }

        $nights = (int) Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));

        Booking::create([
            'user_id'     => auth()->id(),
            'room_id'     => $room->id,
            'check_in'    => $data['check_in'],
            'check_out'   => $data['check_out'],
            'guests'      => $data['guests'],
            'total_price' => $nights * $room->price,
            'status'      => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Your booking has been submitted! Please wait for confirmation.');
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if (in_array($booking->status, ['pending', 'confirmed'])) {
            $booking->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Your booking has been cancelled.');
    }
}