<?php

namespace App\Console\Commands;

use App\Enum\LedgerEnum;
use App\Http\Controllers\WhatsApp;
use App\Models\Developer;
use App\Models\Ledgers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KasCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:kas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Send Alert Kas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstDateThisMonth = Carbon::now()->startOfMonth();
        $lastDateThisMonth = Carbon::now()->endOfMonth();
        $dev = Developer::find(1);

        foreach (User::all() as $acc) {
            $cek = Ledgers::whereBetween('created_at', [$firstDateThisMonth, $lastDateThisMonth])->where('user_id', $acc->id)->where('status', LedgerEnum::IN->value)->first();

            if (!$cek) {

                $msg = "";
                $msg .= "*Informasi*\n\n";
                $msg .= "User : {$acc->name}\n";
                $msg .= "Sudah saatnya membayar kas bulan " . date('M Y') . "\n";
                $msg .= "Sebesar *Rp. " . number_format($dev->kas_default, 0, ',', '.') . "*\n";
                $msg .= "Bayar Ke : ```" . $dev->no_wallet . "A.N : " . $dev->holder_wallet . "```\n";
                $msg .= "Kemudian kirim buktinya ke \n " . route("BayarKas") . "\n\n";
                if ($dev->liburan) {
                    $msg .= "Disclaimer : Liburan Kas Tetap Jalan\n";
                }
                $msg .= "Terima Kasih :D";

                if (!WhatsApp::WhatsAppSendMessage($acc->whatsapp, $msg)) {
                    Log::channel('chat_kas')->error("Gagal mengirim chat kas ke {$acc->name} \n");
                }
            }
        }
    }
}
