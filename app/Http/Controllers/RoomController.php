<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['roomType', 'activeReservation.guest'])->orderBy('room_number')->get();
        $room_types = RoomType::all();

        $by_floor = $rooms->groupBy('floor');

        return view('rooms.index', compact('rooms', 'room_types', 'by_floor'));
    }

    public function markCleaned(Room $room)
    {
        if ($room->status === 'cleaning') {
            $room->update(['status' => 'available']);
            return back()->with('success', "Kamar {$room->room_number} sudah bersih dan siap dipakai.");
        }
        return back()->with('error', 'Kamar tidak dalam status dibersihkan.');
    }

    public function markMaintenance(Room $room)
    {
        $this->authorize('admin');
        $room->update(['status' => 'maintenance']);
        return back()->with('success', "Kamar {$room->room_number} ditandai sebagai maintenance.");
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
        ]);
        Room::create($validated);
        return back()->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function destroy(Room $room)
    {
        $this->authorize('admin');
        $room->delete();
        return back()->with('success', 'Kamar berhasil dihapus.');
    }
}
