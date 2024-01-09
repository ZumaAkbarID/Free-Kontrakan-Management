<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Pengaturan extends Controller
{
    function password(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:4'
        ]);

        try {
            User::find(Auth::user()->id)->update(['password' =>
            Hash::make(config('password.salt_front') . $request->password . config('password.salt_back'))]);

            return redirect()->back()->with('success', 'Ok berhasil coi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Bjir gagal');
        }
    }

    function akun(Request $request)
    {
        $user = parent::getUser();

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id . '|alpha_dash:ascii',
            'whatsapp' => 'required|unique:users,whatsapp,' . $user->id . '|regex:/^08[0-9]+$/|digits_between:10,17|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'whatsapp' => $request->whatsapp
        ];

        $previousPP = $user->image;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image'
            ]);

            if ($previousPP !== "default.png") {
                try {
                    if (Storage::fileExists('/profile/' . $previousPP))
                        Storage::delete('/profile/' . $previousPP);
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', 'Gagal menghapus pp lama');
                }
            }

            $newPPName = $request->username . '.' . $request->file('image')->getClientOriginalExtension();
            $newPP = $request->file('image')->storeAs('profile', $newPPName);

            $data['image'] = $newPPName;
        }

        try {
            User::find($user->id)->update($data);
            return redirect()->back()->with('success', 'Berhasil lur');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Angjay gagal');
        }
    }

    function form()
    {
        $getPiket = parent::isPiketDone();

        return view('Pengaturan', [
            'title' => 'Pengaturan Akun',
            'user' => parent::getUser(),
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
        ]);
    }
}