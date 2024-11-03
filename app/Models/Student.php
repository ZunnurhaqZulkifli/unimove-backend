<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Relationships

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'student_id');
    }
}
