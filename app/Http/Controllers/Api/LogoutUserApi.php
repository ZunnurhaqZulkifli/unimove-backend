<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LogoutUserApi extends BaseApiController
{
    public function logout()
    {
        $user = Auth::user();

        $user->tokens()->delete();
        return $this->success([], 'Logout Successful', 200);
    }
}
