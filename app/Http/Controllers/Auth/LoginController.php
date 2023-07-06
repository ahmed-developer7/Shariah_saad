<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('microsoft')->stateless()->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('microsoft')->stateless()->user();

        $existingUser = User::where('email', $user->getEmail())->first();
        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            return redirect('/login')->withErrors(['email' => 'No user found against the email. Please contact the administrator.']);
        }

        return redirect('/admin');
    }
}
