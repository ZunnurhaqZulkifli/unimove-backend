<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetMyOrdersApi extends BaseApiController
{
    public function index()
    {
        $user_id = Auth::user()->id;

        if(!$user_id || auth()->user()->typeable_type == null) {
            return $this->error([], 'Unauthorized', 401);
        }

        $user = User::find($user_id);

        // if($user->typeable_type == 'App\Models\Driver') {
        //     $orders = Order::where('orderable_id', $user->typeable_id)->orderBy('id', 'asc')->get();
        //     return $this->success($orders, 'Booking fetched successfully', 200);
        // }

        $orders = Order::where('orderable_id', $user->typeable_id)
            ->orderBy('id', 'asc')
            ->where('status', 'new')
            ->get();

        return $this->success($orders, 'Orders fetched successfully', 200);
    }
}
