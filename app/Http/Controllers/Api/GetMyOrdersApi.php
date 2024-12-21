<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetMyOrdersApi extends BaseApiController
{
    public function index()
    {
        $user_id = Auth::user()->id;

        if(!$user_id) {
            return $this->error([], 'Unauthorized', 401);
        }

        $user = User::find($user_id);

        if($user->typeable_type == 'App\Models\Driver') {
            $orders = $user->profile->orders()->orderBy('id', 'asc')->get();
            return $this->success($orders, 'Booking fetched successfully', 200);
        }

        $orders = $user->profile->orders()->orderBy('id', 'asc')->get();
        return $this->success($orders, 'Orders fetched successfully', 200);
    }
}
