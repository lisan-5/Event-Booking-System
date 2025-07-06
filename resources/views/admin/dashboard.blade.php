@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text display-4">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <p class="card-text display-4">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Events</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentEvents as $event)
                        <li class="list-group-item">
                            <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                            <span class="float-right">{{ $event->start_date->format('M d, Y') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Bookings</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentBookings as $booking)
                        <li class="list-group-item">
                            <strong>{{ $booking->user->name }}</strong> booked 
                            <a href="{{ route('events.show', $booking->event) }}">{{ $booking->event->title }}</a>
                            <span class="float-right">{{ $booking->created_at->diffForHumans() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
