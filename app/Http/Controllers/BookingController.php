<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Notifications\BookingConfirmed;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $bookings = Auth::user()->bookings()
                    ->with(['event' => function($query) {
                        $query->withTrashed();
                    }])
                    ->latest()
                    ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Event $event)
    {
        if ($event->available_seats <= 0) {
            return back()->with('error', 'This event is fully booked.');
        }

        if (Auth::user()->bookings()->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'You have already booked this event.');
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'status' => 'confirmed',
            'booking_date' => now(),
        ]);

        $event->updateAvailableSeats();

        // Send notification
        Notification::send(Auth::user(), new BookingConfirmed($booking));

        return redirect()->route('bookings.show', $booking)
                        ->with('success', 'Booking confirmed! Check your email for details.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['event', 'user']);
        return view('bookings.show', compact('booking'));
    }

    public function downloadTicket(Booking $booking)
    {
        $this->authorize('view', $booking);

        $qrCode = QrCode::size(200)->generate(route('bookings.verify', $booking->ticket_number));

        $pdf = Pdf::loadView('bookings.ticket', [
            'booking' => $booking,
            'qrCode' => $qrCode,
        ]);

        return $pdf->download("ticket-{$booking->ticket_number}.pdf");
    }

    public function verify($ticketNumber)
    {
        $booking = Booking::where('ticket_number', $ticketNumber)->firstOrFail();
        $booking->load(['event', 'user']);

        return view('bookings.verify', compact('booking'));
    }
}
