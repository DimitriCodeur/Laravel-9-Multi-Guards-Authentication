<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*=======================================
    LOGIN USER VALIDATION
    =======================================*/
    public function CheckUser(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:30',
        ],[
            'email.required' => 'This email is not exist in the database'
        ]);

        $creds = $request->only('email','password');

        if(Auth::guard('web')->attempt($creds)){
            return redirect()->route('user.home');
        }else{
            return redirect()->route('user.login')->with('fail', 'Incorrect Credentails');
        }

    } //End Method

    /*=======================================
    LOGOUT USER
    =======================================*/
    public function UserLogout(Request $request){
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    } //End Method

    

}
