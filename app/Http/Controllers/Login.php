<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function process(Request $request)
    {

        $remember = $request->exists('remember') ? true : false;
        $passwordHashed = config('password.salt_front') . $request->password . config('password.salt_back');

        if (Auth::attempt(['username' => $request->username, 'password' => $passwordHashed], $remember))
            return redirect()->to(route('Dashboard'));
        else
            return redirect()->back()->withInput()->with('error', 'Akun ora ketemu');
    }

    public function form()
    {
        return view('Auth.Login');
    }
}
