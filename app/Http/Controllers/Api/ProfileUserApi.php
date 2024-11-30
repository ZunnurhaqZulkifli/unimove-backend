<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileUserApi extends BaseApiController
{
    public function profile()
    {
        $user = request()->user();

        if(!$user) {
            return $this->error([], 'Unauthorized', 401);
        }

        $user['profile'] = $user->profile;
        $user['wallet'] = $user->wallet;
        $user['biometric'] = $user->biometric;

        $user['typeable_type'] = $this->parseModelType($user->typeable_type ?? 'user');

        return $this->success($user, 'Profile Retrieved Successfully', 200);
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
