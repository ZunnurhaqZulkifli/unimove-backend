<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Enums\OrderStatus;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Wallet;
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

        if($order->status != 'New') {
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

        $user_wallet = User::where('typeable_id', $order->owner->id)->first()->wallet;
        $order_owner = User::where('typeable_id', $order->owner->id)->first();

        $calculate = new CalculateDataApi();
        
        $data = json_encode(
            $calculate->calculate(Request::create('/api/calculate', 'POST', [
                'df' => $order->pickup_from,
                'dt' => $order->dropoff_to,
            ]))->getData()->data
        );

        $c_data = json_decode($data, true);

        $model = BookingDetail::create([
            'reference_code' => Booking::find($booking->id)->reference_code,
            'user_id' => $order_owner->id,
            'booking_id' => $booking->id,
            'driver_id' => User::find($user->id)->profile->id,
            'vehicle_id' => Vehicle::where('driver_id', User::find($user->id)->profile->id)->first()->id,
            'user_wallet_id' => $user_wallet->id,
            'driver_wallet_id' => Wallet::where('user_id', $user->id)->first()->id,
            'destination_id' => Order::find($order->id)->dropoff_to,
            'pickup_from' => Order::find($order->id)->pickup_from,
            'pickup_time' => now(),
            'dropoff_to' => Order::find($order->id)->dropoff_to,
            'dropoff_time' => now(),
            'price' => $c_data['data']['price'],
            'estimation_time' => $c_data['data']['estimation_time'],
            'distance' => $c_data['data']['distance'],
            'cancellable' => true,
            'created_at' => now(),
        ]);

        return $this->success([$order, $booking, $model], 'Order Accepted Successfully', 200);
    }
}
