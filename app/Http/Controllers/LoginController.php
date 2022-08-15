<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function signin(Request $request){
        //validate input
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //attempt login
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->remember)){
            // redirect successful login
            $request->session()->regenerate();

            return redirect()->route('/');
        }
        //else return an alert
        return back()->withErrors(['status' => 'invalid login details']);
    }
}
