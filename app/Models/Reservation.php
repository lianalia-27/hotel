<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'guest_id',
        'room_id',
        'user_id',
        'num_persons',
        'arrival_date',
        'arrival_time',
        'departure_date',
        'room_rate',
        'total_amount',
        'status',
        'safety_deposit_box',
        'issued_by',
        'issued_date',
        'checked_in_at',
        'checked_out_at',
        'notes',

        // ── Booking / Konfirmasi ──────────────
        'to_name',
        'company_agent',
        'book_by',
        'contact_phone',
        'contact_email',
        'hotel_telp',
        'hotel_fax',
        'hotel_email',
        'booking_date',

        // ── Pembayaran ────────────────────────
        'mandiri_account',
        'mandiri_account_name',
        'card_number',
        'card_holder_name',
        'card_type',
        'bank_transfer_to',
        'card_expired',
    ];

    protected $casts = [
        'arrival_date'   => 'date',
        'departure_date' => 'date',
        'issued_date'    => 'date',
        'booking_date'   => 'date',
        'checked_in_at'  => 'datetime',
        'checked_out_at' => 'datetime',
        'room_rate'      => 'decimal:2',
        'total_amount'   => 'decimal:2',
    ];

    // ── Relasi ──────────────────────────────

    /** Tamu yang melakukan reservasi */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /** Kamar yang dipesan */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /** Staff/resepsionis yang input */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessor ────────────────────────────

    /** Hitung jumlah malam */
    public function getTotalNightsAttribute(): int
    {
        if ($this->arrival_date && $this->departure_date) {
            return (int) $this->arrival_date->diffInDays($this->departure_date);
        }
        return 0;
    }

    // ── Boot: auto-generate booking_number ──

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->booking_number) {
                $date  = now()->format('Ymd');
                $count = static::whereDate('created_at', today())->count() + 1;
                $model->booking_number = 'BK-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
