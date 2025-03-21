<?php
// app/Http/Responses/RegisterViewResponse.php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterViewResponseContract;
use Illuminate\Contracts\Support\Responsable;

class RegisterViewResponse implements RegisterViewResponseContract, Responsable
{
    public function toResponse($request)
    {
        return view('auth.register'); // 登録ビューを返す
    }
}