<?php

namespace App\Console\Commands;

use App\Http\Controllers\WhatsApp;
use App\Models\Developer;
use App\Models\Hari;
use App\Models\JadwalPiket;
use App\Models\Piket;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PiketCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:piket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dev = Developer::find(1);

        foreach (User::all() as $acc) {
            $hari = Hari::where('day_en', date('l'))->first();

            $id = CarbonImmutable::now()->locale('id_ID');

            $dayStartWeek = $id->startOfWeek();
            $dayEndWeek = $id->endOfWeek();

            $cekDonePiket = Piket::whereBetween('created_at', [$dayStartWeek, $dayEndWeek])->with('user')->where('user_id', $acc->id)->where('hari_id', $hari->id)->first();

            $donePiket = ($cekDonePiket) ? true : false;
            $isPiket = false;

            if (!$donePiket) {
                $cekIsPiket = JadwalPiket::where('hari_id', $hari->id)->where('user_id', $acc->id)->first();
                if ($cekIsPiket)
                    $isPiket = true;
            }

            if ($isPiket && !$donePiket && !$dev->liburan) {
                $msg = "";
                $msg .= "*Informasi*\n\n";
                $msg .= "User : {$acc->name}\n";
                $msg .= "Hari ini giliran kamu piket :D \n";
                $msg .= "Piket -> foto -> kirim buktinya ke : \n";
                $msg .= route("Piket") . "\n\nTerima Kasih :D";

                if (!WhatsApp::WhatsAppSendMessage($acc->whatsapp, $msg)) {
                    Log::channel('chat_piket')->error("Gagal mengirim chat piket ke {$acc->name} \n");
                }
            }
        }
    }
}
