<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRideApi extends BaseApiController
{
    public function order(Request $request)
    {
        $user_id = Auth::user()->id;

        if(!$user_id) {
            return $this->error([], 'Unauthorized', 401);
        }

        $user = User::find($user_id);

        $calculate = new CalculateDataApi();
        
        $data = json_encode(
            $calculate->calculate(Request::create('/api/calculate', 'POST', [
                'df' => $request->pickup_from,
                'dt' => $request->dropoff_to,
            ]))->getData()->data
        );

        $c_data = json_decode($data, true);

        $order = new Order();
        $order->owner()->associate($user->profile);
        $order->pickup_from = $request->pickup_from;
        $order->dropoff_to = $request->dropoff_to;
        $order->status = OrderStatus::NEW;
        $order->price = $c_data['data']['price'];
        $order->distance = $c_data['data']['distance'];
        $order->estimation_time = $c_data['data']['estimation_time'];
        $order->save();

        return $this->success($order, 'Order Created Successfully', 200);
    }
}
