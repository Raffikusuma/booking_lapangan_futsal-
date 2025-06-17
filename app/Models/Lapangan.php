<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $fillable = ['name', 'price_per_hour'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
}

