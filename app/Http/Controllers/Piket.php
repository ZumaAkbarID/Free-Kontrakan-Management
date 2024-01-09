<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\Piket as ModelsPiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Piket extends Controller
{
    function upload(Request $request)
    {
        $user = parent::getUser();

        $imgName = Str::slug($user->name) . '-' . Carbon::now()->week . '-' . Carbon::now()->year;
        $imgExtension = $request->file('bukti')->getClientOriginalExtension();

        $upload = ImageKit::upload(base64_encode($request->file('bukti')->getContent()), $imgName, $imgExtension);
        if (!is_null($upload['error']))
            return redirect()->back()->with('error', 'Ono kesalahan pas upload file reng API');

        $url = $upload['result']['url'];

        // Memecah URL berdasarkan "/"
        $urlParts = explode('/', $url);

        // Menemukan indeks di mana bagian "kontrakanboys" berada
        $index = array_search('kontrakanboys', $urlParts);

        // Menambahkan "tr:pr-true,lo-true" setelah "kontrakanboys"
        array_splice($urlParts, $index + 1, 0, ['tr:pr-true,lo-true']);

        // Menggabungkan kembali URL
        $newUrl = implode('/', $urlParts);

        try {
            $data = [
                'hari_id' => Hari::where('day_en', Carbon::now()->dayName)->first()->id,
                'user_id' => $user->id,
                'bukti' => $newUrl
            ];

            ModelsPiket::create($data);

            return redirect()->to(route('Piket'))->with('success', "OK SIR NAIS");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Create Lur');
        }
    }

    public function index()
    {
        $jadwal = Hari::with('jadwal.user')->get();

        $getPiket = parent::isPiketDone();

        return view('Piket', [
            'title' => 'Piket',
            'user' => parent::getUser(),
            'jadwal' => $jadwal,
            'isPiket' => $getPiket[2],
            'donePiket' => $getPiket[1],
            'history' => ModelsPiket::with(['hari', 'user'])->orderBy('created_at', 'DESC')->get(),
            'kasLunas' => parent::isKasLunas()
        ]);
    }
}
