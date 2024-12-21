<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner()
    {
        return $this->morphTo('orderable');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
