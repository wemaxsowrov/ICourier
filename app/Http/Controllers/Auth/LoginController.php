<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Services\SmsService;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

    // Auth login 
    public function login(Request $request)
    {
        // Active Remember me 24 houre
        if($request->remember != null)
        {
            Cookie::queue('useremail',$request->email,1440);
            Cookie::queue('userpassword',$request->password,1440);
        }
        else
        {
            Cookie::queue(Cookie::forget('useremail'));
            Cookie::queue(Cookie::forget('userpassword'));
        }
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            //login security 
            if(auth()->user()->status == Status::ACTIVE && auth()->user()->verification_status == Status::INACTIVE):
                session([
                    'otp'     => auth()->user()->otp,
                    'mobile'  => auth()->user()->mobile,
                    'password'=> $request->password
                ]);
                $response =  app(SmsService::class)->sendOtp(auth()->user()->mobile,auth()->user()->otp);
                auth()->logout();
                return redirect()->route('merchant.otp-verification-form');
            endif;
            //end login security 
 
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

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

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email')))
        {
            return ['mobile' => $request->get('email'),'password' => $request->get('password'), 'status' => '1', ];
        }
        return ['email' => $request->get('email'),'password' => $request->get('password'), 'status' => '1', ];
    }
}
