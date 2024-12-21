<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserWalletsApi extends BaseApiController
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $wallet->update($request->all());

        return $this->success($wallet, 'Wallets updated successfully', 200);
    }
}
