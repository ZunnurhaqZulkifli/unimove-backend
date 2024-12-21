<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class GetOrdersApi extends BaseApiController
{
    public function index()
    {
        $orders = Order::where('status',  'new')->orderBy('id', 'asc')->get();
        return $this->success($orders, 'Orders fetched successfully', 200);
    }
}
