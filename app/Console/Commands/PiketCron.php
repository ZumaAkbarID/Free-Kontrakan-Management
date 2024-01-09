<?php

namespace App\Console\Commands;

use App\Http\Controllers\WhatsApp;
use App\Models\Developer;
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
            $userJadwalPiket = User::with('jadwalPiket.hari')->find($acc->id);

            $hari = $userJadwalPiket->jadwalPiket->map(function ($item) {
                return [
                    $item->hari->day_en,
                    $item->hari->id,
                ];
            })->all();

            $id = CarbonImmutable::now()->locale('id_ID');

            $dayStartWeek = $id->startOfWeek();
            $dayEndWeek = $id->endOfWeek();

            $cekPiket = Piket::whereBetween('created_at', [$dayStartWeek, $dayEndWeek])->with('user')->get();

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
