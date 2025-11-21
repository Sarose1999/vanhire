<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminBookingCreatedNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New Booking Created by ' . $this->booking->user->name,
            'booking_id' => $this->booking->id,
            'pickup' => $this->booking->pickup_location,
            'dropoff' => $this->booking->dropoff_location,
            'start_date' => $this->booking->start_date,
        ];
    }
}
