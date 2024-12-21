<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;

class GetUserWalletsApi extends BaseApiController
{
    public function wallet()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        return $this->success($wallet, 'Wallets fetched successfully', 200);
    }
}
