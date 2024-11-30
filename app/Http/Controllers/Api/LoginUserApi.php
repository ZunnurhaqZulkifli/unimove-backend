<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserApi extends BaseApiController
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$authenticate = Auth::attempt($credentials)) {
            return $this->error([], 'The Entered Password / Email is incorrect.', 401);
        }

        $user = Auth::user();
        $user['token'] = $user->createToken('auth_token')->plainTextToken;
        $user['profile'] = $user->profile;
        $user['typeable_type'] = $this->parseModelType($user->typeable_type ?? 'user');

        return $this->success($user, 'Login Successful', 200);
    }

    public function parseModelType(string $type) {
        switch ($type) {
            case 'App\Models\Student':
                return 'student';
            case 'App\Models\Staff':
                return 'staff';
            case 'App\Models\Driver':
                return 'driver';
            default:
                return null;
        }
    }
}
