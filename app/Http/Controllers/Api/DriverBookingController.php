<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverBookingController extends BaseApiController
{
    public function check(Request $request)
    {
        $user = Auth::user();

        $booking = Booking::where('accepted_by', $user->id)
            ->where('status', '!=', 'completed')
            ->first();

        if(!isset($booking)) {
            return $this->success(false, 'Driver Have No Booking', 200);
        }

        return $this->success(true, 'Driver Booking', 200);
    }
    //

    public function getBooking()
    {
        $user = Auth::user();

        $booking = Booking::where('accepted_by', $user->id)
            ->where('status', '!=', 'completed')
            ->first();

        if(isset($booking)) {
            $booking_detail = BookingDetail::where('booking_id', $booking->id)
                ->with('driver')
                ->with('vehicle.model')
                ->with('vehicle.brand')
                ->with('pickupFrom')
                ->with('dropOff')
                ->first();

            $bookingData = [
                'booking' => $booking,
                'booking_detail' => $booking_detail ?? null,
            ];
        }

        if(!isset($bookingData)){
            return $this->error('Booking not found', 404);
        }

        return $this->success($bookingData, 'Driver Booking', 200);
    }

    public function onGoingRide(Request $request)
    {
        $user = Auth::user();

        $booking = Booking::where('accepted_by', $user->id)
            ->where('status', '!=', 'completed')
            ->first();

        if(!isset($booking)) {
            return $this->error('Booking not found', 404);
        }

        $booking->status = 'ongoing';
        $booking->save();

        return $this->success($booking, 'On Going Ride', 200);
    }

    public function completeRide(Request $request)
    {
        $user = Auth::user();

        $booking = Booking::where('accepted_by', $user->id)
            ->where('status', 'ongoing')
            ->first();

        if(!isset($booking)) {
            return $this->error('Booking not found', 404);
        }
        
        $booking->status = 'completed';
        $booking->save();

        $order = Order::find($booking->order_id);
        $order->status = 'completed';
        $order->save();

        $bookingDetail = BookingDetail::where('booking_id', $booking->id)->get()->first();

        $driver_profile = User::where('typeable_type',  'App\Models\Driver')->where('typeable_id', $bookingDetail->driver_id)->get();

        $driver_profile = User::where('typeable_type', 'App\Models\Driver')
            ->where('typeable_id', $bookingDetail->driver_id)
            ->first();

        if ($driver_profile) {
            $driver_wallet = Wallet::where('user_id', $driver_profile->id)->first();
            if ($driver_wallet) {
                $driver_wallet->balance += $bookingDetail->price;
                $driver_wallet->save();
            }
        }

        $customer_profile = User::where('typeable_type', 'App\Models\Student')
            ->where('typeable_id', $bookingDetail->user_id)
            ->first();

        if ($customer_profile) {
            $customer_wallet = Wallet::where('user_id', $customer_profile->id)->first();
            if ($customer_wallet) {
                $customer_wallet->balance -= $bookingDetail->price;
                $customer_wallet->save();
            }
        }

        return $this->success($booking, 'Ride Completed', 200);
    }
}
