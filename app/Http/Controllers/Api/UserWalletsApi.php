<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;

class UserWalletsApi extends BaseApiController
{
    public function wallet()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        return $this->success($wallet, 'Wallet fetched successfully', 200);
    }
}
