<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    // protected $redirectTo = '/home';
    // protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => 1];
    }

    public function redirectTo(){

        // User role
        $roles = Auth::user()->roles;

        // User_Type
        $user_type  =  Auth::user()->user_type;

        if(strcasecmp($user_type ,'root')==0){
            return '/dashboard';
        }else if(strcasecmp($user_type ,'admin')==0){
            return '/dashboard';
        }else{
            return '/home';
        }

        /*
        // Check user role
        switch ($role) {
            case 'Manager':
                    return '/dashboard';
                break;
            case 'Employee':
                    return '/projects';
                break;
            default:
                    return '/login';
                break;
        }
        */
    }
}
