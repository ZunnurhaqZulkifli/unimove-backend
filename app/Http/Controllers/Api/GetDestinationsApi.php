<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class GetDestinationsApi extends BaseApiController
{
    public function index()
    {
        $destinations = Destination::all();
        return $this->success($destinations, 'Destinations Retrieved Successfully', 200);
    }
}
