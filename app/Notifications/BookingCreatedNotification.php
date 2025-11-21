<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + database notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Booking is Confirmed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your booking has been successfully created.')
            ->line('Pickup Location: ' . $this->booking->pickup_location)
            ->line('Drop-off Location: ' . $this->booking->dropoff_location)
            ->line('Start Date: ' . $this->booking->start_date)
            ->line('End Date: ' . $this->booking->end_date)
            ->line('Total Price: Rs. ' . $this->booking->total_price)
            ->action('View Booking', url('/bookings/' . $this->booking->id))
            ->line('Thank you for booking with us!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking has been created successfully.',
        ];
    }
}
