<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordExpiredRequest;
use Illuminate\Support\Facades\Hash;

class ExpiredPasswordController extends Controller
{
    public function expired()

    {
        return view('auth.passwords.expired');
    }

   public function postExpired(PasswordExpiredRequest $request) //PasswordExpiredRequest
    {

        if (!Hash::check($request->current_password, $request->user()->password)) {

            return redirect()->back()->withErrors(['current_password' => 'Не верный текущий пароль']);

        }

        $request->user()->update([

            'password' => bcrypt($request->password),

          //  'password_changed_at' => Carbon::now()->toDateTimeString()

        ]);

        return redirect()->back()->with(['status' => 'Пароль изменен']);

    }
}
