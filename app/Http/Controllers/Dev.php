<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;

class Dev extends Controller
{
    function save(Request $request)
    {
        $data = $request->except('_token');
        $data['liburan'] = ($request->liburan == "on") ? true : false;
        Developer::find(1)->update($data);
        return redirect()->back()->with('success', 'OK ZUMA GANTENG');
    }

    function index()
    {
        $getPiket = parent::isPiketDone();
        $user = parent::getUser();

        return view('Dev', [
            'title' => 'Talangan',
            'user' => $user,
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
            'dev' => Developer::find(1)
        ]);
    }
}
