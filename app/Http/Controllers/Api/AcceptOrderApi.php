<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcceptOrderApi extends BaseApiController
{
    public function accept(Request $request)
    {
        $user = Auth::user();

        if(!$user) {
            return $this->error([], 'Unauthorized', 401);
        }

        $order = Order::find($request->order_id);

        if(!$order) {
            return $this->error([], 'Order Not Found', 404);
        }

        if($order->status != 'new') {
            return $this->error([], 'Order Already Accepted', 400);
        }

        $booking = new Booking();
        $booking->reference_code = 'B'.rand(100000, 999999);
        $booking->accepted_by = User::find($user->id)->profile->id;
        $booking->order_id = $order->id;
        $booking->status = BookingStatus::ACCEPTED;
        $booking->save();
        
        $order->status = OrderStatus::BOOKED;
        $order->save();

        return $this->success([$order, $booking], 'Order Accepted Successfully', 200);
    }
}
