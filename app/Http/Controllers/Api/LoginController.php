<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Обрабатываем попытку входа пользователей. Переопределили метод login()
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

/*
            $request->user()->forceFill([
                'api_token' => hash('sha256', $user->api_token),
            ])->save();*/

            return ['token' => $user->api_token];

            /*return response()->json([
                'token' => $user->api_token]);

                //$user->toArray(),
                'Authorization' => ['Bearer' => $user->api_token ]
            ])
                ->header('api_token', $user->api_token)
                ->header('Content-Type', 'application/json');*/
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Если токен отсутствует или пропущен, пользователь должен получать сообщение о том,
     * что он не авторизован и удалить токен в базе данных
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }

}
