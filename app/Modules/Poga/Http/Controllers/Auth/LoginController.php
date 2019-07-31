<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Http\Controllers\Controller;
use Raffles\Modules\Poga\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

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

    use AuthenticatesUsers, FormatsValidJsonResponses;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return false;
        }

        if (\Hash::check($request->password, $user->password)) {
            $this->guard()->setUser($user);
            return true;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        try {
            $user = $this->guard()->user();
            $user->load('permissions', 'roles');
            $token = $user->createToken(env('APP_NAME'));
            $accessToken = $token->accessToken;
        } catch (\Exception $e) {
            return $this->validInternalServerErrorJsonResponse($e, $e->getMessage());
        }

        $data = [
            'token' => $accessToken,
            'user' => $user
        ];

        return $this->validSuccessJsonResponse('Success', $data);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }
}
