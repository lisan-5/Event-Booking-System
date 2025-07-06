<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('events', EventController::class)->except(['destroy']);
Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

Route::middleware('auth')->group(function () {
    Route::post('events/{event}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/download', [BookingController::class, 'downloadTicket'])->name('bookings.download');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::post('users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.users.assign-role');
});
