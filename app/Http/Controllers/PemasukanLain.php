<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
use App\Models\Ledgers;
use App\Models\User;
use Illuminate\Http\Request;

class PemasukanLain extends Controller
{
    function save(Request $request)
    {
        try {
            $final_balance = Ledgers::latest()->first();
            if (is_null($final_balance))
                $finalBal = $request->amount;
            else
                $finalBal = $final_balance->final_balance + $request->amount;

            $data = [
                'user_id' => $request->user_id,
                'transaction_purpose' => $request->tujuan,
                'status' => LedgerEnum::IN->value,
                'amount' => $request->amount,
                'final_balance' => $finalBal
            ];

            Ledgers::create($data);

            return redirect()->back()->with('success', "OK SIR NAIS");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Create Lur');
        }
    }

    function index()
    {
        $user = parent::getUser();
        $getPiket = parent::isPiketDone();

        return view('PemasukanLain', [
            'title' => 'Pemasukan Lain',
            'user' => $user,
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
            'allUser' => User::all()
        ]);
    }
}
