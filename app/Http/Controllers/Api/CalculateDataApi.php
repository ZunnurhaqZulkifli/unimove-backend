<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class CalculateDataApi extends BaseApiController
{
    public function calculate(Request $request)
    {
        $request->validate([
            'df' => 'required|exists:destinations,id',
            'dt' => 'required|exists:destinations,id',
        ]);

        $d1 = Destination::find($request->df);
        $d2 = Destination::find($request->dt);

        $time = abs($d2['x'] - $d1['x']) + abs($d2['y'] - $d1['y']);

        if($time < 1) {
            $data = [
                'distance' => 0.25,
                'price' => 3.00,
                'estimation_time' => 1,
            ];
        } else {
            $data = [
                'distance' => $time * 0.5,
                'price' => ($time * 1.25 < 3) ? 3.00 : $time * 1.25,
                'estimation_time' => $time * 2,
            ];
        }

        return $this->success(['data' => $data], 200);
    }
}
