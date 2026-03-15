<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::latest()->get();
        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'code'            => 'required|string|max:10|unique:room_types,code',
            'description'     => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_capacity'    => 'required|integer|min:1',
            'facilities'      => 'nullable|string',
        ]);

        RoomType::create([
            'name'            => $request->name,
            'code'            => strtoupper($request->code),
            'description'     => $request->description,
            'price_per_night' => $request->price_per_night,
            'max_capacity'    => $request->max_capacity,
            'facilities'      => $request->facilities,
        ]);

        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil ditambahkan!');
    }

    public function show(RoomType $roomType)
    {
        return view('room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'code'            => 'required|string|max:10|unique:room_types,code,' . $roomType->id,
            'description'     => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_capacity'    => 'required|integer|min:1',
            'facilities'      => 'nullable|string',
        ]);

        $roomType->update([
            'name'            => $request->name,
            'code'            => strtoupper($request->code),
            'description'     => $request->description,
            'price_per_night' => $request->price_per_night,
            'max_capacity'    => $request->max_capacity,
            'facilities'      => $request->facilities,
        ]);

        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil diperbarui!');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil dihapus!');
    }

    public function toggleStatus(RoomType $roomType)
    {
        $roomType->update(['is_active' => !$roomType->is_active]);
        return back()->with('success', 'Status tipe kamar berhasil diubah!');
    }
}