<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Van extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'image',
        'seats',
        'price_per_day',
    ];

    protected $casts = [
    'images' => 'array'
];

    // Van has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
