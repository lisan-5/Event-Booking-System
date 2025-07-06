<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Event::with('organizer')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Organizer',
            'Start Date',
            'End Date',
            'Location',
            'Total Seats',
            'Available Seats',
            'Price',
            'Status'
        ];
    }

    public function map($event): array
    {
        return [
            $event->id,
            $event->title,
            $event->organizer->name,
            $event->start_date->format('Y-m-d H:i'),
            $event->end_date->format('Y-m-d H:i'),
            $event->location,
            $event->total_seats,
            $event->available_seats,
            $event->price,
            $event->start_date > now() ? 'Upcoming' : 'Completed'
        ];
    }
}
