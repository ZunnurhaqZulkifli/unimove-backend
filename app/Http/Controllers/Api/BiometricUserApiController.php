<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiometricUserApiController extends BaseApiController
{
    public function biometric()
    {
        $user = Auth::user();
        $biometric = $user->biometric;

        return $this->set_success($biometric, 'Biometric data retrieved successfully');
    }
}
