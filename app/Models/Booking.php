<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'booking_start_date',
        'booking_end_date',
        'status',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
