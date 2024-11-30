<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Biometric;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterUserApi extends BaseApiController
{
    public function register(Request $request)
    {
        $userValidator = new StoreUserRequest();
        $studentValidator = new StoreStudentRequest();
        $data = $request->all();

        $rules = $userValidator->rules();
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 400);
        }

        $validator->validated();

        if($request->typeable_type != null) {
            switch ($data['typeable_type']) {
                case 'App\Models\Student':
                    $rules = $studentValidator->rules();
    
                    $validator = Validator::make([
                        'name'       => $request->name,
                        'student_id' => $request->student_id, // student
                        'phone'      => $request->student_phone,
                        'address'    => $request->student_address,
                    ], $rules);
    
                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Student Validation Error', 400);
                    }
    
                    $validatedStudentData = $validator->validated();
                    $model = Student::create($validatedStudentData);
                    
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
        }
        
        $user = User::create([
            'typeable_type'     => $data['profile_type'] ?? null,
            'typeable_id'       => $model->id ?? null,
            'name'              => $request->name,
            'username'          => $request->username,
            'email'             => $request->email,
            'email_verified_at' => now(),
            'tac'               => $request->tac,
            'remember_token'    => random_int(0, 100),
            'password'          => $request->password,
        ]);

        $user['token'] = $user->createToken('auth_token')->plainTextToken;

        $user->biometric()->create([
            'face_id' => false,
            'fingerprint' => false,
            'passcode' => true,
            'enabled' => false,
            'passcode_number' => '0000',
        ]);

        return $this->success([
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }
}
