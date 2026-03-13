<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\Guest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'available_rooms' => Room::where('status', 'available')->count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'cleaning_rooms' => Room::where('status', 'cleaning')->count(),
            'total_rooms' => Room::count(),
            'checked_in_today' => Reservation::whereDate('arrival_date', today())->where('status', 'checked_in')->count(),
            'checked_out_today' => Reservation::whereDate('departure_date', today())->where('status', 'checked_out')->count(),
            'total_guests' => Guest::count(),
            'active_reservations' => Reservation::whereIn('status', ['reserved', 'checked_in'])->count(),
        ];

        $recent_reservations = Reservation::with(['guest', 'room.roomType', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $rooms = Room::with('roomType')->get();

        return view('dashboard.index', compact('stats', 'recent_reservations', 'rooms'));
    }
}
