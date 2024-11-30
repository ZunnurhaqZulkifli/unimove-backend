<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeleteUserApi extends BaseApiController
{
    public function delete()
    {
        $user = request()->user();
        $password = request()->password;

        if (!$password) {
            return $this->error([], 'Password is required', 400);
        } else {

            if($user->profile != null) {
                $user->profile()->delete();
            }
            
            $user->tokens()->delete();
            User::where('id', $user->id)->delete();
    
            return $this->success([], 'User Deleted Successfully', 200);
        }
    }
}
