<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class UserRidesHistoryApi extends BaseApiController
{
    public function rides()
    {
        $user = Auth::user();
        $data = [];

        if(!$user) {
            return $this->error([], 'Unauthorized', 401);
        }

        if($user->typeable_type == 'App\Models\Driver') {
            $bookings = Booking::where('accepted_by', $user->id)
                ->whereIn('status', ['completed'])
                ->get();

            if($bookings->isNotEmpty()) {
                foreach($bookings as $booking) {
                    $data[] = [
                        'booking' => $booking,
                        'booking_detail' => BookingDetail::where('booking_id', $booking->id)
                            ->with('driver')
                            ->with('vehicle.model')
                            ->with('vehicle.brand')
                            ->with('pickupFrom')
                            ->with('dropOff')
                            ->get(),
                    ];
                }
            }

            if($data == null) {
                $data = [];
    
                return $this->success($data, 'The Driver Bookings is Empty !', 200);
            }
    
            return $this->success($data, 'Fetched Driver Bookings Successfully', 200);
        }
        
        $bookings = Booking::join('orders', 'bookings.order_id', '=', 'orders.id')
            ->whereHas('order', function($query) use ($user) {
                $query->where('orderable_id', $user->typeable_id)
                    ->whereIn('orderable_type', [$user->typeable_type]);
            })
            ->whereIn('bookings.status', ['completed'])
            ->get();
        
        if($bookings->isNotEmpty()) {
            foreach($bookings as $booking) {
                $data[] = [
                    'booking' => $booking,
                    'booking_detail' => BookingDetail::where('booking_id', $booking->id)
                        ->with('driver')
                        ->with('vehicle.model')
                        ->with('vehicle.brand')
                        ->with('pickupFrom')
                        ->with('dropOff')
                        ->get(),
                ];
            }
        } 

        if($data == null) {
            $data = [];

            return $this->success($data, 'The User Bookings is Empty !', 200);
        }

        return $this->success($data, 'Fetched User Bookings Successfully', 200);
    }
}
