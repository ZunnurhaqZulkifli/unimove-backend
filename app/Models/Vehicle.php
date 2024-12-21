<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    // Relationships
    
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
