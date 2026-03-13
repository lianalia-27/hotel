<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name', 'profession', 'company', 'nationality',
        'id_card_number', 'passport_number', 'birth_date',
        'address', 'phone', 'mobile_phone', 'email', 'member_number'
    ];

    protected $casts = ['birth_date' => 'date'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
