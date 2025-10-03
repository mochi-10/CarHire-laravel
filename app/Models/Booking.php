<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = [
        'car_id',
        'user_id',
        'total_days',
        'total_km',
        'amount_to_pay',
        'booking_status',
        'payment_status',
        'return_status',
        'return_date',
        'return_time',
        'payment_method',
        'transaction_reference',
        'checkout_request_id',
        'mpesa_receipt_number',
        'transaction_date',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
