<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
use App\Models\Hari;
use App\Models\JadwalPiket;
use App\Models\Ledgers;
use App\Models\Piket;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getUser()
    {
        return Auth::check() ? Auth::user() : null;
    }

    public function isKasLunas()
    {
        $firstDateThisMonth = Carbon::now()->startOfMonth();
        $lastDateThisMonth = Carbon::now()->endOfMonth();

        return (Ledgers::whereBetween('created_at', [$firstDateThisMonth, $lastDateThisMonth])->where('user_id', Auth::user()->id)->where('status', LedgerEnum::IN->value)->get()->count() > 0) ? true : false;
    }

    public function isPiketDone()
    {
        $user = Auth::user();
        $hari = Hari::where('day_en', date('l'))->first();

        $id = CarbonImmutable::now()->locale('id_ID');

        $dayStartWeek = $id->startOfWeek();
        $dayEndWeek = $id->endOfWeek();

        $cekDonePiket = Piket::whereBetween('created_at', [$dayStartWeek, $dayEndWeek])->with('user')->where('user_id', $user->id)->where('hari_id', $hari->id)->first();

        $donePiket = ($cekDonePiket) ? true : false;
        $isPiket = false;

        if (!$donePiket) {
            $cekIsPiket = JadwalPiket::where('hari_id', $hari->id)->where('user_id', $user->id)->first();
            if ($cekIsPiket)
                $isPiket = true;
        }

        return [
            '', // ini biar ga error, males ganti semua wkakwa
            $donePiket,
            $isPiket
        ];
    }
}
