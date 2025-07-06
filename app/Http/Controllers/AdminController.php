<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Exports\EventsExport;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        $stats = [
            'totalEvents' => Event::count(),
            'activeEvents' => Event::upcoming()->count(),
            'totalUsers' => User::count(),
            'newUsers' => User::where('created_at', '>', now()->subDays(30))->count(),
            'totalBookings' => Booking::count(),
            'revenue' => Booking::sum('event_price')
        ];

        $recentEvents = Event::latest()->take(5)->get();
        $recentBookings = Booking::with(['user', 'event'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentBookings'));
    }

    public function events(Request $request)
    {
        $query = Event::query();

        if ($request->has('status')) {
            if ($request->status === 'upcoming') {
                $query->upcoming();
            } elseif ($request->status === 'past') {
                $query->where('end_date', '<', now());
            }
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $events = $query->with('organizer')->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function exportEvents()
    {
        return Excel::download(new EventsExport, 'events-'.Carbon::now()->format('Y-m-d').'.xlsx');
    }

    public function exportBookings()
    {
        return Excel::download(new BookingsExport, 'bookings-'.Carbon::now()->format('Y-m-d').'.xlsx');
    }

    // ... rest of the admin methods
}
