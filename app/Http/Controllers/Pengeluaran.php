<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
use App\Models\Ledgers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Pengeluaran extends Controller
{
    function save(Request $request)
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
            $final_balance = Ledgers::latest()->first();
            if (is_null($final_balance))
                $finalBal = -$request->amount;
            else
                $finalBal = $final_balance->final_balance - $request->amount;

            $data = [
                'user_id' => $user->id,
                'transaction_purpose' => $request->tujuan,
                'status' => LedgerEnum::OUT->value,
                'amount' => $request->amount,
                'final_balance' => $finalBal,
                'manual_prof' => $newUrl
            ];

            Ledgers::create($data);

            return redirect()->to(route('Dashboard'))->with('success', "OK SIR NAIS");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Create Lur');
        }
    }

    function index()
    {
        $user = parent::getUser();
        $getPiket = parent::isPiketDone();

        return view('Pengeluaran', [
            'title' => 'Pengeluaran',
            'user' => $user,
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
        ]);
    }
}