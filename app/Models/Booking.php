<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'van_id',
        'start_date',
        'end_date',
        'time',
        'pickup_location',
    'dropoff_location',
        'total_days',     // ✅ Add this
        'total_price',    // ✅ Add this
        'status',
    ];

    public function van()
    {
        return $this->belongsTo(Van::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
