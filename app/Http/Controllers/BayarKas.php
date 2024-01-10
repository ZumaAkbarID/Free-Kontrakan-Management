<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
use App\Models\Developer;
use App\Models\Ledgers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BayarKas extends Controller
{
    function upload(Request $request)
    {
        if (parent::isKasLunas())
            return redirect()->to(route('Dashboard'))->with('error', 'Udah ngirim boss');

        $user = parent::getUser();

        $imgName = Str::slug($user->name) . '-' . date('M-Y');
        $imgExtension = $request->file('bukti')->getClientOriginalExtension();

        $upload = ImageKit::upload(base64_encode($request->file('bukti')->getContent()), $imgName, $imgExtension);
        if (!is_null($upload['error']))
            return redirect()->back()->with('error', 'Ono kesalahan pas upload file reng API');

        $kasDefault = Developer::find(1)->kas_default;

        $url = $upload['result']['url'];

        // Memecah URL berdasarkan "/"
        $urlParts = explode('/', $url);

        // Menemukan indeks di mana bagian "kontrakanboys" berada
        $index = array_search('kontrakanboys', $urlParts);

        // Menambahkan "tr:pr-true,lo-true" setelah "kontrakanboys"
        array_splice($urlParts, $index + 1, 0, ['tr:pr-true,lo-true']);

        // Menggabungkan kembali URL
        $newUrl = implode('/', $urlParts);

        $final_balance = Ledgers::latest()->first();
        if (is_null($final_balance))
            $finalBal = $kasDefault;
        else
            $finalBal = $final_balance->final_balance + $kasDefault;

        try {
            $data = [
                'user_id' => $user->id,
                'transaction_purpose' => "Bayar Kas",
                'status' => LedgerEnum::IN->value,
                'amount' => $kasDefault,
                'final_balance' => $finalBal,
                'manual_prof' => $newUrl
            ];

            Ledgers::create($data);

            $msg = "";
            $msg .= "*Laporan Kas Masuk*\n\n";
            $msg .= "User : {$user->name}\n";
            $msg .= "Tulung dicek lur \n";
            $msg .= "Bukti : \n";
            $msg .= $newUrl;

            foreach (User::where('role', 'Bendahara')->orWhere('role', 'Developer')->get() as $acc) {
                if (!WhatsApp::WhatsAppSendMessage($acc->whatsapp, $msg)) {
                    Log::channel('chat_kas')->error("Gagal mengirim chat ingfo kas dari {$user->name} ke {$acc->name} \n");
                }
            }

            return redirect()->to(route('Dashboard'))->with('success', "OK SIR NAIS");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Create Lur');
        }
    }

    function index()
    {
        $getPiket = parent::isPiketDone();

        return view('BayarKas', [
            'title' => 'Bayar Kas',
            'user' => parent::getUser(),
            'donePiket' => $getPiket[1],
            'isPiket' => $getPiket[2],
            'kasLunas' => parent::isKasLunas(),
            'developer' => Developer::find(1)
        ]);
    }
}
