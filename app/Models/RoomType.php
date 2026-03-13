<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = ['name', 'code', 'description', 'price_per_night', 'max_capacity', 'facilities'];

    protected $casts = ['facilities' => 'array'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
