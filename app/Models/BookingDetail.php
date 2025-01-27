<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function dropOff()
    {
        return $this->belongsTo(Destination::class, 'dropoff_to');
    }

    public function pickupFrom()
    {
        return $this->belongsTo(Destination::class, 'pickup_from');
    }

    public function vehicle()
    {
        // kene tambah vehicle_id
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
