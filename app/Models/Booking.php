<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'van_id',
        'start_date',
        'end_date',
        'time',
        'pickup_location',
        'dropoff_location',
        'total_days',
        'total_price',
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

    protected static function booted()
{
    static::created(function ($booking) {

        // Notify customer
        $booking->user->notify(
            new \App\Notifications\BookingCreatedNotification($booking)
        );

        // Notify admin (user_id = 1 OR role = admin)
        $admin = \App\Models\User::where('role', 'admin')->first();

        if ($admin) {
            $admin->notify(
                new \App\Notifications\AdminBookingCreatedNotification($booking)
            );
        }
    });
}

}
