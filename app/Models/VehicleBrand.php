<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
    protected $guarded = ['id'];

    public function models()
    {
        return $this->hasMany(VehicleModel::class);
    }
}
