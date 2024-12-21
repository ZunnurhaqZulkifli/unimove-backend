<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreUserRequest;
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
        $staffValidator = new StoreStaffRequest();
        $driverValidator = new StoreDriverRequest();
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

                    $rules = $staffValidator->rules();
    
                    $validator = Validator::make([
                        'name'       => $request->name,
                        'staff_id'   => $request->staff_id,
                        'phone'      => $request->phone,
                        'address'    => $request->address,
                    ], $rules);
    
                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Staff Validation Error', 400);
                    }
    
                    $validatedStaffData = $validator->validated();
                    $model = Staff::create($validatedStaffData);
            
                    $data['profile_type'] = 'App\Models\Staff';
                    break;
    
                case 'App\Models\Driver':

                    $rules = $driverValidator->rules();
    
                    $validator = Validator::make([
                        'name'           => $request->name,
                        'driver_id'      => $request->driver_id,
                        'phone'          => $request->phone,
                        'address'        => $request->address,
                        'license_no'     => $request->license_no,
                        'license_expiry' => $request->license_expiry,
                    ], $rules);
    
                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Driver Validation Error', 400);
                    }
    
                    $validatedDriverData = $validator->validated();
                    $model = Driver::create($validatedDriverData);
            
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
