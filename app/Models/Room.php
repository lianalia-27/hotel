<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'room_type_id', 'floor', 'status', 'notes'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function activeReservation()
    {
        return $this->hasOne(Reservation::class)->whereIn('status', ['reserved', 'checked_in']);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'success',
            'occupied' => 'danger',
            'cleaning' => 'warning',
            'maintenance' => 'secondary',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'cleaning' => 'Sedang Dibersihkan',
            'maintenance' => 'Maintenance',
            default => 'Unknown',
        };
    }
}
