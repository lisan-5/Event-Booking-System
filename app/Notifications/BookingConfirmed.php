<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Booking Confirmation')
                    ->line('Thank you for booking '.$this->booking->event->title)
                    ->line('Booking Reference: '.$this->booking->ticket_number)
                    ->action('View Booking', route('bookings.show', $this->booking))
                    ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your booking for '.$this->booking->event->title.' is confirmed',
            'url' => route('bookings.show', $this->booking)
        ];
    }
}
