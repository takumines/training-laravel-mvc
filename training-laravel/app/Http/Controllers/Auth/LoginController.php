<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    /**
     * ログイン画面を返す
     *
     * @return view
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 認証方法をuserに設定
     *
     * @return Illumiante\Support\Facades\Auth;
     */
    public function guard()
    {
        return Auth::guard('user');
    }

    /**
     * ログアウト処理
     *
     * @return view
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/login');
    }
}
