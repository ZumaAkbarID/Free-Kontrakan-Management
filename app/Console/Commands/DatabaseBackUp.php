<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use CURLFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

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
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";
        $path = storage_path() . "/app/backup/" . $filename;

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $path;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        $CHAT_ID = '894168042';
        $BOT = '6664534491:AAEkDMfKRcpQoC7jObA2f0Vf_4XNwi3bz3o';

        // Create CURL object
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $BOT . "/sendDocument?chat_id=" . $CHAT_ID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Create CURLFile
        $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        $cFile = new CURLFile($path, $finfo);

        // Add CURLFile to CURL request
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "document" => $cFile,
            "caption" => "Backup DB Kontrakan"
        ]);

        // Call
        $result = json_decode(curl_exec($ch), true);

        // Show result and close curl
        // var_dump($result);
        curl_close($ch);

        if ($result['ok'] == true) {
            unlink($path);
        }
    }
}
