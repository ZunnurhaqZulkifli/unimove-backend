<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserApiController extends BaseApiController
{
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->name = $request['name'] ?? $user->name;
        $user->password = Hash::make($request['password']);
        $user->email = $request['email'];
        $user->save();

        return $this->set_success($user, 'User updated successfully');
    }
}
