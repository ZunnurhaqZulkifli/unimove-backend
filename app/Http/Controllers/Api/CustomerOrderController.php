<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Api\CalculateDataApi;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends BaseApiController
{
    public function check(Request $request)
    {
        $user = Auth::user();

        $order = Order::where('orderable_id', $user->typeable_id)
            ->where('orderable_type', $user->typeable_type)
            ->where('status', '!=', 'completed')
            ->first();

        if(!isset($order)) {
            return $this->success(false, 'User Have No Orders', 200);
        }

        return $this->success(true, 'User Order', 200);
    }

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

    public function cancelOrder(Request $request)
    {
        $user_id = Auth::user()->id;

        if(!$user_id) {
            return $this->error([], 'Unauthorized', 401);
        }

        $order = Order::find($request->order_id);

        if(!$order) {
            return $this->error([], 'Order Not Found', 404);
        }

        if($order->status != 'New') {
            return $this->error([], 'Order Already Accepted', 400);
        }

        $order->status = OrderStatus::CANCELLED;
        $order->save();

        return $this->success($order, 'Order Cancelled Successfully', 200);
    }

    public function getOrder(Request $request)
    {
        $user_id = Auth::user()->id;

        if(!$user_id) {
            return $this->error([], 'Unauthorized', 401);
        }

        $user = User::find($user_id);

        $orders = Order::where('orderable_id', $user->typeable_id)
            ->where('orderable_type', $user->typeable_type)
            ->where('status', '!=', 'completed')
            ->get();

        return $this->success($orders, 'User Orders', 200);
    }
}
