<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'lapangan_id',
        'user_id',
        'nama_pemesan',
        'no_hp',
        'start_time',
        'end_time'
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}