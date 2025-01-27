<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\Vehicle;
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
                        'staff_id'  => $data['staff_id'],
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
                        'driver_id'      => $data['driver_id'],
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


            if($data['profile_type'] == 'App\Models\Driver') {            
                Vehicle::create([
                    'driver_id' => $model->id,
                    'plate_no' => 'XXX' . rand(1000, 9999),
                    'model_id' => rand(1, 84),
                    'brand_id' => rand(1, 10),
                    'color' => 'black',
                    'mileage' => rand(1000, 999999),
                ]);
            }

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 50.00,
                'bank_id' => 1,
                'card_number' => '1234567890123456',
                'card_expiry' => '12/25',
                'card_ccv' => '123',
                'card_holder' => $user->name,
                'card_type' => 'debit',
            ]);
        }

        return $this->success([
            'user' => $user,
        ]);
    }
}
