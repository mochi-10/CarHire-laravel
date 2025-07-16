<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        // 'model',
        'registration_number',
        'year',
        'color',
        'image',
        'rate_per_day',
        'rate_per_km',
        'car_model_id',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }
}
