<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $guarded = ['id'];
    protected $table = 'staffs';

    public function orders()
    {
        return $this->hasMany(Order::class, 'orderable_id');
    }
}
