# Event Ticketing System

A robust Laravel application for managing events, ticket bookings, and attendee verification with QR codes. Includes features for organizers, attendees, and administrators.

## Features

### User Features
- User registration with email verification
- Browse upcoming events with search and filtering
- Book tickets for events
- View booking history
- Download PDF tickets with QR codes
- Receive email notifications for bookings

### Organizer Features
- Create and manage events
- Set event details (date, location, capacity, price)
- Upload event images
- Track ticket sales and availability
- Manage event categories

### Admin Features
- Full system dashboard with analytics
- Manage users and roles (admin, organizer, user)
- Export event and booking data
- View all system events and bookings
- Assign organizer privileges

### Technical Features
- QR code ticket verification
- PDF ticket generation
- Email notifications
- Role-based access control
- Data export to Excel
- Responsive design

## Requirements

- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js 16+
- Redis (for queues, optional)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/lisan-5/Event-Booking-System.git
cd Event-Booking-System
```

Install dependencies:
composer install
npm install

Create and configure .env file:
cp .env.example .env

Generate application key:
php artisan key:generate

Run migrations and seeders:
php artisan migrate --seed

Compile assets:
npm run build

Set up queue worker (optional for email notifications):
php artisan queue:work
Configuration
Important environment variables to configure:

APP_URL=
DB_* (database credentials)
MAIL_* (email settings)
QUEUE_CONNECTION=redis/database/sync
Usage
Development
php artisan serve
npm run dev
Production
Configure your web server to point to the public directory.

Commands
php artisan events:check-expired - Mark past events as expired (schedule in cron)
php artisan queue:work - Process queued jobs (emails)
API Endpoints
The system provides a RESTful API for integration:

GET /api/events - List events
GET /api/events/{id} - Show event details
POST /api/events/{id}/book - Create booking (authenticated)
GET /api/bookings - User bookings (authenticated)
Security
CSRF protection
XSS prevention
SQL injection prevention
Role-based authorization
Input validation
Password hashing
Rate limiting
License
MIT License
