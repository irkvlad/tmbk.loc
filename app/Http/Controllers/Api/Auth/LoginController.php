<?php

namespace App\Http\Controllers\Api\Auth;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($creds)) {
            return response()->json(['error' => true, 'message'=> 'Incorrect login'], 401);
        }
        return response()->json(['error' => false,'token' => $token],202);

    }
}
