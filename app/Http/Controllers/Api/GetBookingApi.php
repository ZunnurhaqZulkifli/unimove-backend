<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\Auth;

class GetBookingApi extends BaseApiController
{
    public function index(){
        $user = Auth::user();

        // if you wanna get the booking_details that has booking 
        // $booking = BookingDetail::join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
        //     ->join('orders', 'bookings.order_id', '=', 'orders.id')
        //     ->where('orders.orderable_id', $user->typeable_id)
        //     ->where('orders.orderable_type', $user->typeable_type)
        //     ->with('booking')
        //     ->first();
        
        // this is the correct way to get the booking
        $booking = Booking::whereHas('order', function($query) use ($user) {
            $query->where('orderable_id', $user->typeable_id)
                ->where('orderable_type', $user->typeable_type);
        })->with('bookingDetails')->first();

        if(!isset($booking)){
            return $this->error('Booking not found', 404);
        }

        return $this->success($booking, 'User Booking', 200);
    }
}
