<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'booking_number', 'guest_id', 'room_id', 'user_id',
        'num_persons', 'arrival_date', 'arrival_time', 'departure_date',
        'room_rate', 'total_amount', 'status',
        'safety_deposit_box', 'issued_by', 'issued_date', 'notes',
        'checked_in_at', 'checked_out_at'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
        'issued_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalNightsAttribute(): int
    {
        if ($this->arrival_date && $this->departure_date) {
            return $this->arrival_date->diffInDays($this->departure_date);
        }
        return 0;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'reserved' => 'Reservasi',
            'checked_in' => 'Check In',
            'checked_out' => 'Check Out',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'reserved' => 'info',
            'checked_in' => 'success',
            'checked_out' => 'secondary',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($reservation) {
            if (!$reservation->booking_number) {
                $reservation->booking_number = 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
