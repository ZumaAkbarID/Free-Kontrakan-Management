<?php

namespace App\Http\Controllers;

use App\Enum\LedgerEnum;
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
        $userJadwalPiket = User::with('jadwalPiket.hari')->find(Auth::user()->id);

        $hari = $userJadwalPiket->jadwalPiket->map(function ($item) {
            return [
                $item->hari->day_en,
                $item->hari->id,
            ];
        })->all();

        $id = CarbonImmutable::now()->locale('id_ID');

        $dayStartWeek = $id->startOfWeek();
        $dayEndWeek = $id->endOfWeek();

        $cekPiket = Piket::whereBetween('created_at', [$dayStartWeek, $dayEndWeek])->with('user')->where('user_id', Auth::user()->id)->get();
        $donePiket = false;

        foreach ($cekPiket as $data) {
            for ($i = 0; $i < count($hari); $i++) {
                if ($data->hari_id === $hari[$i][1]) {
                    $donePiket = true;
                    break;
                }
            }
            if ($donePiket)
                break;
        }

        $isPiket = false;

        if (!$donePiket) {
            $hariToFind = Carbon::now()->dayName;

            foreach ($hari as $data) {
                if ($data[0] === $hariToFind) {
                    $isPiket = true;
                    break;
                }
            }
        }

        return [
            $hari,
            $donePiket,
            $isPiket
        ];
    }
}
