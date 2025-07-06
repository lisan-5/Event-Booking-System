<!DOCTYPE html>
<html>
<head>
    <title>Event Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .ticket { border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .qr-code { text-align: center; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Event Ticket</h1>
            <h2>{{ $booking->event->title }}</h2>
        </div>
        
        <div class="details">
            <p><strong>Ticket Number:</strong> {{ $booking->ticket_number }}</p>
            <p><strong>Attendee:</strong> {{ $booking->user->name }}</p>
            <p><strong>Event Date:</strong> {{ $booking->event->start_date->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $booking->event->start_date->format('g:i A') }} - {{ $booking->event->end_date->format('g:i A') }}</p>
            <p><strong>Location:</strong> {{ $booking->event->venue }}, {{ $booking->event->location }}</p>
        </div>
        
        <div class="qr-code">
            {!! $qrCode !!}
        </div>
        
        <div class="footer">
            <p>Present this ticket at the event entrance. No refunds or exchanges.</p>
        </div>
    </div>
</body>
</html>
