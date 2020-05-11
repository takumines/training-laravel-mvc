<?php

namespace App\Http\Controllers\Admin\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

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
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
    private $authManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request): JsonResponse
    {
        $guard = $this->authManager->guard('api_admin');
        $token = $guard->attempt([
            'email' =>  $request->get('email'),
            'password'  =>  $request->get('password'),
        ]);
        if (!$token) {
            return new JsonResponse(__('auth.failed'));
        }
        return new JsonResponse($token);
    }
}
