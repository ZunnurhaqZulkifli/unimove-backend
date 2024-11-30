<?php

namespace App\Http\Controllers\Api;

use App\Models\Biometric;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserBiometricApi extends BaseApiController
{
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $type = $request->input('type', null);
        $reset = $request->input('reset', false);
        $initial = $request->input('initial', false);
        $biometric = $user->biometric;

        if (!$biometric) {
            Biometric::create([
                'user_id' => $user->id,
                'face_id' => false,
                'fingerprint' => false,
                'passcode' => false,
                'enabled' => true,
                'passcode_number' => 0000,
            ]);
        }

        if($reset) {
            $biometric->face_id = false;
            $biometric->passcode = true;
            $biometric->fingerprint = false;
            $biometric->enabled = true;
            $biometric->save();

            return $this->set_success($biometric, 'Biometric reset successfully');
        }

        if($biometric->enabled == false && $initial) {

            if($request->input('passcode_number') == null) {
                return $this->error('Passcode number is required');
            }

            $biometric->face_id = false;
            $biometric->passcode = true;
            $biometric->fingerprint = false;
            $biometric->enabled = true;
            $biometric->passcode_number = $request->input('passcode_number');
            $biometric->save();

            return $this->set_success($biometric, 'Biometric updated successfully');
        }

        switch ($type) {
            case 'face_id':
                $biometric->face_id = true;
                $biometric->passcode = true;
                $biometric->fingerprint = false;
                $biometric->enabled = true;
                $biometric->save();
                
                break;
            case 'fingerprint' : 
                $biometric->face_id = false;
                $biometric->passcode = true;
                $biometric->fingerprint = true;
                $biometric->enabled = true;
                $biometric->save();
                
                break;

            case 'passcode':
                $biometric->face_id = false;
                $biometric->passcode = true;
                $biometric->fingerprint = false;
                $biometric->enabled = true;
                $biometric->save();
                
                break;
            
            default:
                return $this->error('Invalid biometric type');
        }

        return $this->set_success($biometric, 'Biometric updated successfully');
    }
}
