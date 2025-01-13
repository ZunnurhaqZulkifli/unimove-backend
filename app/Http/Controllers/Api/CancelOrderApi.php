<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CancelOrderApi extends BaseApiController
{
    public function cancel(Request $request)
    {
        $order = Order::find($request->order_id);

        if(!$order) {
            return $this->error([], 'Order Not Found', 404);
        }

        $order->status = OrderStatus::CANCELLED;
        $order->save();

        return $this->success($order, 'Order Cancelled Successfully', 200);
    }
}
