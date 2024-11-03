<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = ['id'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'driver_id');
    }
}
