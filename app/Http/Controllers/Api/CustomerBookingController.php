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

class CustomerBookingController extends BaseApiController
{
    public function check(Request $request)
    {
        $user = Auth::user();

        $booking = Booking::join('orders', 'bookings.order_id', '=', 'orders.id')
            ->whereHas('order', function($query) use ($user) {
                $query->where('orderable_id', $user->typeable_id)
                    ->where('orderable_type', $user->typeable_type);
            })
            ->where('bookings.status', '!=', 'completed')
            ->first();

        if(!isset($booking)) {
            return $this->success(false, 'User Have No Booking', 200);
        }

        return $this->success(true, 'User Booking', 200);
    }

    public function getBooking(Request $request) {
        $user = Auth::user();

        $booking = Booking::join('orders', 'bookings.order_id', '=', 'orders.id')
            ->whereHas('order', function($query) use ($user) {
                $query->where('orderable_id', $user->typeable_id)
                    ->where('orderable_type', $user->typeable_type);
            })
            ->where('bookings.status', '!=', 'completed')
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
        
        if (!isset($bookingData)) {
            return $this->error('Booking not found', 200);
        }

        return $this->success($bookingData, 'User Booking', 200);
    }

    public function onGoingRide(Request $request)
    {
        $user = Auth::user();

        $booking = Booking::join('orders', 'bookings.order_id', '=', 'orders.id')
            ->whereHas('order', function($query) use ($user) {
                $query->where('orderable_id', $user->typeable_id)
                    ->where('orderable_type', $user->typeable_type);
            })
            ->where('bookings.status', '!=', 'completed')
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
        return $this->success($user, 'Ride Completed', 200);
    }
}
