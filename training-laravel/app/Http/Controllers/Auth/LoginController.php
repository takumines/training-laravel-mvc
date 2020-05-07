<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;
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

    /**
     * Twitter経由での認証処理をスタート
     *
     * @return Socialite
     */
    public function redirectToTwitterProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterProviderCallback()
    {
        try {
            $user = Socialite::with("twitter")->user();
        }
        catch (\Exception $e) {
            return redirect('/login')->with('flash_message', 'ログインに失敗しました');
        }

        $myinfo = User::firstOrCreate(['token' => $user->token ],
                    [
                        'name' => $user->name,
                        'email' => $user->getEmail(),
                        'password'=> 'DUMMY_PASSWORD',
                        ]);
                    Auth::login($myinfo);

                    return redirect()->to('/');
    }
}
