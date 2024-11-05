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

    protected $guarded = ['id'];

    protected $table = "students";

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
