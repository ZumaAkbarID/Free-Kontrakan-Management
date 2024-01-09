<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Controller
{
    public function process()
    {
        Auth::logout();
        Session::regenerate();
        Session::flush();
        return redirect()->to(route('Login'));
    }
}
