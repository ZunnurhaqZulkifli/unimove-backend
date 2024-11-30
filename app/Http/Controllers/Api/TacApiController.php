<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TacApiController extends BaseApiController
{
    public function sendTac()
    {
        $name = request()->name;
        $email = request()->email;
        $tac = rand(100000, 999999);

        Mail::to($email)->send(new \App\Mail\SendTac($tac, $name));

        return $this->success(['tac' => $tac], 'Tac Sent Successfully', 200);
    }
}
