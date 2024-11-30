<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRideApi extends BaseApiController
{
    public function order(Request $request)
    {
        $user = Auth::user();

        if(!$user) {
            return $this->error([], 'Unauthorized', 401);
        }

        $order = new Order();
        $order->owner()->associate($user);
        $order->pickup_from = $request->pickup_from;
        $order->dropoff_to = $request->dropoff_to;
        $order->status = OrderStatus::NEW;
        $order->save();

        return $this->success($order, 'Order Created Successfully', 200);
    }
}
