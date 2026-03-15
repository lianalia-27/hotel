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
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari di booking_number langsung di tabel reservations
                $q->where('booking_number', 'like', "%{$search}%")
                  // Cari di tabel guests via relasi (aman karena pakai whereHas)
                  ->orWhereHas('guest', function ($gq) use ($search) {
                      $gq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('company', 'like', "%{$search}%");
                  });
            });
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
            'room_id'              => 'required|exists:rooms,id',
            'num_persons'          => 'required|integer|min:1',
            'arrival_date'         => 'required|date',
            'arrival_time'         => 'nullable',
            'departure_date'       => 'required|date|after:arrival_date',
            // Guest data
            'name'                 => 'required|string|max:255',
            'profession'           => 'nullable|string',
            'company'              => 'nullable|string',
            'nationality'          => 'nullable|string',
            'id_card_number'       => 'nullable|string',
            'passport_number'      => 'nullable|string',
            'birth_date'           => 'nullable|date',
            'address'              => 'nullable|string',
            'phone'                => 'nullable|string',
            'mobile_phone'         => 'nullable|string',
            'email'                => 'nullable|email',
            'member_number'        => 'nullable|string',
            'safety_deposit_box'   => 'nullable|string',
            // Booking info
            'to_name'              => 'nullable|string|max:255',
            'company_agent'        => 'nullable|string|max:255',
            'book_by'              => 'nullable|string|max:255',
            'contact_phone'        => 'nullable|string|max:50',
            'contact_email'        => 'nullable|email|max:255',
            'hotel_telp'           => 'nullable|string|max:50',
            'hotel_fax'            => 'nullable|string|max:50',
            'hotel_email'          => 'nullable|email|max:255',
            'booking_date'         => 'nullable|date',
            // Payment info
            'mandiri_account'      => 'nullable|string|max:100',
            'mandiri_account_name' => 'nullable|string|max:255',
            'card_number'          => 'nullable|string|max:20',
            'card_holder_name'     => 'nullable|string|max:255',
            'card_type'            => 'nullable|string|max:50',
            'bank_transfer_to'     => 'nullable|string|max:255',
            'card_expired'         => 'nullable|string|max:10',
        ]);

        DB::transaction(function () use ($validated, $request) {

            $guest = Guest::create([
                'name'            => $validated['name'],
                'profession'      => $validated['profession']     ?? null,
                'company'         => $validated['company']        ?? null,
                'nationality'     => $validated['nationality']    ?? 'Indonesia',
                'id_card_number'  => $validated['id_card_number'] ?? null,
                'passport_number' => $validated['passport_number'] ?? null,
                'birth_date'      => $validated['birth_date']     ?? null,
                'address'         => $validated['address']        ?? null,
                'phone'           => $validated['phone']          ?? null,
                'mobile_phone'    => $validated['mobile_phone']   ?? null,
                'email'           => $validated['email']          ?? null,
                'member_number'   => $validated['member_number']  ?? null,
            ]);

            $room   = Room::with('roomType')->find($validated['room_id']);
            $nights = \Carbon\Carbon::parse($validated['arrival_date'])
                        ->diffInDays(\Carbon\Carbon::parse($validated['departure_date']));
            $total  = $room->roomType->price_per_night * $nights;

            $reservation = Reservation::create([
                'guest_id'             => $guest->id,
                'room_id'              => $validated['room_id'],
                'user_id'              => Auth::id(),
                'num_persons'          => $validated['num_persons'],
                'arrival_date'         => $validated['arrival_date'],
                'arrival_time'         => $validated['arrival_time'],
                'departure_date'       => $validated['departure_date'],
                'room_rate'            => $room->roomType->price_per_night,
                'total_amount'         => $total,
                'status'               => 'checked_in',
                'safety_deposit_box'   => $validated['safety_deposit_box']   ?? null,
                'issued_by'            => Auth::user()->name,
                'issued_date'          => today(),
                'checked_in_at'        => now(),
                // Booking info
                'to_name'              => $validated['to_name']              ?? null,
                'company_agent'        => $validated['company_agent']        ?? null,
                'book_by'              => $validated['book_by']              ?? null,
                'contact_phone'        => $validated['contact_phone']        ?? null,
                'contact_email'        => $validated['contact_email']        ?? null,
                'hotel_telp'           => $validated['hotel_telp']           ?? null,
                'hotel_fax'            => $validated['hotel_fax']            ?? null,
                'hotel_email'          => $validated['hotel_email']          ?? null,
                'booking_date'         => $validated['booking_date']         ?? today(),
                // Payment info
                'mandiri_account'      => $validated['mandiri_account']      ?? null,
                'mandiri_account_name' => $validated['mandiri_account_name'] ?? null,
                'card_number'          => $validated['card_number']          ?? null,
                'card_holder_name'     => $validated['card_holder_name']     ?? null,
                'card_type'            => $validated['card_type']            ?? null,
                'bank_transfer_to'     => $validated['bank_transfer_to']     ?? null,
                'card_expired'         => $validated['card_expired']         ?? null,
            ]);

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
        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orWhere('id', $reservation->room_id)
            ->get();
        return view('reservations.edit', compact('reservation', 'rooms'));
    }

    public function checkOut(Reservation $reservation)
    {
        DB::transaction(function () use ($reservation) {
            $reservation->update([
                'status'         => 'checked_out',
                'checked_out_at' => now(),
            ]);
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
