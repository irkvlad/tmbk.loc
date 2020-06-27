<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | Этот контроллер отвечает за обработку подтверждений пароля и
    | использует простую черту, чтобы включить поведение. Вы можете исследовать
    | эта черта и переопределить любые функции, которые требуют настройки.
    |
    */

    use ConfirmsPasswords;

    /**
     * Куда перенаправлять пользователей в случае сбоя предполагаемого URL.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Создает новый экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
