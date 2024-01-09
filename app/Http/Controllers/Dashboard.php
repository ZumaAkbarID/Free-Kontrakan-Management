<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
use App\Models\Developer;
use App\Models\Ledgers;
use App\Models\Talangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Dashboard extends Controller
{

    function index()
    {
        $firstDateThisMonth = Carbon::now()->startOfMonth();
        $lastDateThisMonth = Carbon::now()->endOfMonth();

        $sisaSaldo = Ledgers::whereBetween('created_at', [$firstDateThisMonth, $lastDateThisMonth])->orderBy('created_at', 'DESC')->first('final_balance');
        $kasTerkumpul = Ledgers::whereBetween('created_at', [$firstDateThisMonth, $lastDateThisMonth])->where('status', LedgerEnum::IN->value)->sum('amount');
        $kasDefault = Developer::find(1)->kas_default;
        $allUser = User::count('id');
        $kurangOrang = (($allUser * $kasDefault) - $kasTerkumpul) / $kasDefault;

        $getPiket = parent::isPiketDone();

        return view('Dashboard', [
            'title' => 'Dashboard',
            'user' => parent::getUser(),
            'ledgers' => Ledgers::whereBetween('created_at', [$firstDateThisMonth, $lastDateThisMonth])->with('user')->get(),
            'sisaSaldo' => (!is_null($sisaSaldo)) ? $sisaSaldo->final_balance : 0,
            'kasTerkumpul' => $kasTerkumpul,
            'donePiket' => $getPiket[1],
            'kasLunas' => parent::isKasLunas(),
            'isPiket' => $getPiket[2],
            'kurangOrang' => floor($kurangOrang),
            'talanganBersama' => Talangan::where('dikembalikan', false)->sum('amount')
        ]);
    }
}