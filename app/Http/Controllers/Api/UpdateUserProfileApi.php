<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateUserProfileApi extends BaseApiController
{
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $studentValidator = new StoreStudentRequest();
        $staffValidator = new StoreStaffRequest();
        $driverValidator = new StoreDriverRequest();

        $data = $request->all();

        if($user == null) {
            return $this->error([], 'User not found', 404);
        }

        if($request->type != null) {
            switch ($data['type']) {
                case 'student':
                    $rules = $studentValidator->rules();
    
                    $validator = Validator::make([
                        'name'       => $user->name,
                        'student_id' => $request->student_id,
                        'phone'      => $request->phone,
                        'address'    => $request->address,
                    ], $rules);
    
                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Student Validation Error', 400);
                    }
    
                    $validatedStudentData = $validator->validated();
                    $model = Student::create($validatedStudentData);
                    
                    $data['profile_type'] = 'App\Models\Student';
                    break;
            
                case 'staff':
                    $rules = $staffValidator->rules();

                    $validator = Validator::make([
                        'name'      => $user->name,
                        'staff_id'  => $data['id'],
                        'phone'     => $data['phone'],
                        'address'   => $data['address'],
                    ], $rules);

                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Staff Validation Error', 400);
                    }

                    $validatedStaffData = $validator->validated();
                    $model = Staff::create($validatedStaffData);
            
                    $data['profile_type'] = 'App\Models\Staff';
                    break;
    
                case 'driver':
                    $rules = $driverValidator->rules();

                    $validator = Validator::make([
                        'name'           => $user->name,
                        'driver_id'      => $data['id'],
                        'phone'          => $data['phone'],
                        'address'        => $data['address'],
                        'license_no'     => $data['license_no'],
                        'license_expiry' => $data['license_expiry'],
                    ], $rules);

                    if ($validator->fails()) {
                        return $this->error($validator->errors(), 'Driver Validation Error', 400);
                    }

                    $validatedDriverData = $validator->validated();
                    $model = Driver::create($validatedDriverData);
            
                    $data['profile_type'] = 'App\Models\Driver';
                    break;
            }

            $user->update([
                'typeable_type'     => $data['profile_type'],
                'typeable_id'       => $model->id,
            ]);

            $user->save();

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 50.00,
            ]);
        }

        return $this->success([
            'user' => $user,
        ]);
    }
}
