<?php

namespace App\Http\Controllers;

use App\Models\Talangan as ModelsTalangan;
use Illuminate\Http\Request;

class Talangan extends Controller
{
    function personal(Request $request)
    {

        $request->validate([
            'tujuan' => 'required|max:255',
            'amount' => 'required|numeric|min:1'
        ]);

        $user = parent::getUser();

        $uid = [
            'user_id' => $user->id,
        ];

        $data = array_merge($uid, $request->except('_token'));

        try {
            ModelsTalangan::create($data);
            return redirect()->back()->with('success', 'Berhasil ditalangi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal ditalangi');
        }
    }

    function kembali(Request $request, $code_id)
    {
        abort_if(!$code_id, 301);
        $id = base64_decode($code_id);

        $cekTalangan = ModelsTalangan::findOrFail($id);

        $user = parent::getUser();
        if ($user->role !== 'Bendahara')
            abort(301);

        try {
            $cekTalangan->update(['dikembalikan' => true]);
            return redirect()->back()->with('success', 'Okeh');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal');
        }
    }

    public function index()
    {
        $getPiket = parent::isPiketDone();
        $user = parent::getUser();

        return view('Talangan', [
            'title' => 'Talangan',
            'user' => $user,
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
            'talanganPersonal' => ModelsTalangan::where('user_id', $user->id)->get(),
            'talanganAll' => ModelsTalangan::with('user')->get(),
        ]);
    }
}
