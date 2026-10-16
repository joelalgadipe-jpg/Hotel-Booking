<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'check_in'  => 'nullable|date|after_or_equal:today',
            'check_out' => 'nullable|date|after:check_in',
            'guests'    => 'nullable|integer|min:1',
        ]);

        $rooms = Room::where('status', 'available')
            ->when($request->filled('guests'), function ($q) use ($request) {
                $q->where('capacity', '>=', $request->guests);
            })
            ->when($request->filled('check_in') && $request->filled('check_out'), function ($q) use ($request) {
                $q->whereDoesntHave('bookings', function ($b) use ($request) {
                    $b->whereIn('status', ['pending', 'confirmed'])
                      ->where('check_in', '<', $request->check_out)
                      ->where('check_out', '>', $request->check_in);
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('welcome', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
}