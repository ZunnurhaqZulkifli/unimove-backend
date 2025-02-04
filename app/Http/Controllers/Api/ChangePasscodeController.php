<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Biometric;
use Illuminate\Support\Facades\Auth;

class ChangePasscodeController extends BaseApiController
{
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $biometric = $user->biometric;
        $passcode_number = $request->input('passcode_number');

        if(!isset($biometric) || $passcode_number == null) {
            return $this->error([], 'User Passcode Has Been Changed / Passcode is empty !');    
        }

        $biometric = Biometric::where('user_id', $user->id)->first();
        $biometric->passcode_number = $passcode_number;
        $biometric->save();

        return $this->success([User::find($user->id)], 'User Passcode Has Been Changed !');
    }
}
