<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sistem\Company;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }

        if (Company::getSettings()->login_common_disabled == '1') {
            return view('errors.403');
        }

        return view('auth.login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required',
            'password' => 'required',
        ]);
    }

    public function login(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = null;

        if (! $user) {
            Log::debug('Authenticating user against database.');
            // Try to log the user in
            if (! Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->input('remember'))) {
                Log::debug('Local authentication failed.');

                return redirect()->back()->withInput()->with('error', 'Email atau password tidak sesuai.');
            } else {
                $this->clearLoginAttempts($request);
            }
        }

        return redirect()->intended('dashboard')->with('success', 'You have successfully logged in');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        //$this->guard()->logoutOtherDevices($request->password);
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
