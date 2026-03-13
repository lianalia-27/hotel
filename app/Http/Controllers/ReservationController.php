<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Guest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['guest', 'room.roomType', 'user'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('guest', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->orWhere('booking_number', 'like', "%{$request->search}%");
        }

        $reservations = $query->paginate(15);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $available_rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();
        $room_types = RoomType::all();
        return view('reservations.create', compact('available_rooms', 'room_types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'num_persons' => 'required|integer|min:1',
            'arrival_date' => 'required|date',
            'arrival_time' => 'nullable',
            'departure_date' => 'required|date|after:arrival_date',
            // Guest data
            'name' => 'required|string|max:255',
            'profession' => 'nullable|string',
            'company' => 'nullable|string',
            'nationality' => 'nullable|string',
            'id_card_number' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'mobile_phone' => 'nullable|string',
            'email' => 'nullable|email',
            'member_number' => 'nullable|string',
            'safety_deposit_box' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create or find guest
            $guest = Guest::create([
                'name' => $validated['name'],
                'profession' => $validated['profession'] ?? null,
                'company' => $validated['company'] ?? null,
                'nationality' => $validated['nationality'] ?? 'Indonesia',
                'id_card_number' => $validated['id_card_number'] ?? null,
                'passport_number' => $validated['passport_number'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'mobile_phone' => $validated['mobile_phone'] ?? null,
                'email' => $validated['email'] ?? null,
                'member_number' => $validated['member_number'] ?? null,
            ]);

            $room = Room::with('roomType')->find($validated['room_id']);
            $nights = \Carbon\Carbon::parse($validated['arrival_date'])
                ->diffInDays(\Carbon\Carbon::parse($validated['departure_date']));
            $total = $room->roomType->price_per_night * $nights;

            $reservation = Reservation::create([
                'guest_id' => $guest->id,
                'room_id' => $validated['room_id'],
                'user_id' => Auth::id(),
                'num_persons' => $validated['num_persons'],
                'arrival_date' => $validated['arrival_date'],
                'arrival_time' => $validated['arrival_time'],
                'departure_date' => $validated['departure_date'],
                'room_rate' => $room->roomType->price_per_night,
                'total_amount' => $total,
                'status' => 'checked_in',
                'safety_deposit_box' => $validated['safety_deposit_box'] ?? null,
                'issued_by' => Auth::user()->name,
                'issued_date' => today(),
                'checked_in_at' => now(),
            ]);

            // Update room status
            $room->update(['status' => 'occupied']);

            session(['last_reservation_id' => $reservation->id]);
        });

        return redirect()->route('reservations.show', session('last_reservation_id'))
            ->with('success', 'Tamu berhasil di check-in! Formulir registrasi dapat dicetak.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['guest', 'room.roomType', 'user']);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $rooms = Room::with('roomType')->where('status', 'available')->orWhere('id', $reservation->room_id)->get();
        return view('reservations.edit', compact('reservation', 'rooms'));
    }

    public function checkOut(Reservation $reservation)
    {
        DB::transaction(function () use ($reservation) {
            $reservation->update([
                'status' => 'checked_out',
                'checked_out_at' => now(),
            ]);
            // Mark room as cleaning
            $reservation->room->update(['status' => 'cleaning']);
        });

        return redirect()->route('reservations.index')
            ->with('success', "Tamu {$reservation->guest->name} berhasil Check Out. Kamar {$reservation->room->room_number} kini sedang dibersihkan.");
    }

    public function print(Reservation $reservation)
    {
        $reservation->load(['guest', 'room.roomType', 'user']);
        return view('reservations.print', compact('reservation'));
    }
}
