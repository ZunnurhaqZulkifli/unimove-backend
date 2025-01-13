<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DashboardImage;
use Illuminate\Http\Request;

class GetDashboardImagesApi extends BaseApiController
{
    public function index()
    {
        $images = DashboardImage::all();
        return $this->success($images, 'Images fetched successfully', 200);
    }
}
