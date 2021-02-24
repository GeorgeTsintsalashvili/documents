<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request; // added

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

    use AuthenticatesUsers {

         logout as userLogout; // rename function
    }

    protected function authenticated() // added
    {
      return ['authenticated' => true, 'redirect' => '/user/home'];
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/home'; // modified

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this -> middleware('guest') -> except('logout');
    }

    public function logout(Request $request) // added
    {
        $this -> userLogout($request);

        return redirect() -> route('login');
    }
}
