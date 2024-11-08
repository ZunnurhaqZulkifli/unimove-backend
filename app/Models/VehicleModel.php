<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $guarded = ['id'];

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }
}
