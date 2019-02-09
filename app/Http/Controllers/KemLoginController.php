<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class KemLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // email
        // password
        // $dotArray = Dot::where([
        //     ['created_at', '>=', $carbon_date_nowSub15hr],
        //     ['created_at', '<=', $carbon_date_nowPlus1hr],
        //     ['user_id', '=', Auth::user()->id]
        // ])->orderby('updated_at', 'desc')->get();

        dd(bcrypt($request->password));
        $user = User::where([
            ['email', '=', $request->email],
            ['password', '=', bcrypt($request->password)],
            ['active', '=' ,1]
        ])->first();

        dd($user);



    }
}
