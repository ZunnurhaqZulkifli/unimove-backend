<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckHasOrder extends BaseApiController
{
    public function index(Request $request)
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
}
