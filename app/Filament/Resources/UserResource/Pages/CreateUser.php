<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use \Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        switch ($data['typeable_type']) {
            case 'App\Models\Student':
                $model = Student::create([
                    'name'       => $data['name'],
                    'student_id' => $data['student_id'],
                    'phone'      => $data['student_phone'],
                    'address'    => $data['student_address'],
                    'status'     => 'active',
                ]);
        
                $data['profile_type'] = 'App\Models\Student';
                break;
        
            case 'App\Models\Staff':
                $model = Staff::create([
                    'name'      => $data['name'],
                    'staff_id'  => $data['staff_id'],
                    'phone'     => $data['staff_phone'],
                    'address'   => $data['staff_address'],
                    'status'    => 'active',
                ]);
        
                $data['profile_type'] = 'App\Models\Staff';
                break;

            case 'App\Models\Driver':
                $model = Driver::create([
                    'name'           => $data['name'],
                    'driver_id'      => $data['driver_id'],
                    'phone'          => $data['driver_phone'],
                    'address'        => $data['driver_address'],
                    'license_no'     => $data['driver_license_no'],
                    'license_expiry' => $data['driver_license_expiry'],
                ]);
        
                $data['profile_type'] = 'App\Models\Driver';
                break;
        }
        
        $user = User::create([
            'typeable_type'     => $data['profile_type'],
            'typeable_id'       => $model->id,
            'name'              => $data['name'],
            'username'          => $data['username'],
            'email'             => $data['email'],
            'email_verified_at' => now(),
            'tac'               => rand(100000, 999999),
            'remember_token'    => random_int(0, 100),
            'password'          => $data['password'],
        ]);

        return $user;
    }
}
