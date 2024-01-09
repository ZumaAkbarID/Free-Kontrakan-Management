<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsApp extends Controller
{
    private static function validatePhoneNumber($phoneNumber)
    {
        // Hanya boleh mengandung angka
        if (!ctype_digit($phoneNumber)) {
            return false;
        }

        // Jika berawalan '08', ganti dengan '628'
        if (strpos($phoneNumber, '08') === 0) {
            $phoneNumber = '628' . substr($phoneNumber, 2);
        }

        // Jika sudah berawalan '628', biarkan saja

        return $phoneNumber;
    }

    public static function WhatsAppSendMessage($whatsapp_number, $text)
    {
        $whatsapp_number = self::validatePhoneNumber($whatsapp_number);

        if ($whatsapp_number == false) {
            return false;
        }

        $query = [
            'number' => $whatsapp_number,
            'msg' => $text,
        ];

        $url = Developer::find(1)->api_wa . '/send-msg';
	Log::channel('api_wa')->info('Endpoin: ' . $url);

        try {
            $response = Http::post($url, $query, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            // Proses $response sesuai kebutuhan Anda
            // echo 'Response: ' . $response->body();
            $decoded = json_decode($response->body(), true);

            if (key_exists('status', $decoded)) {
                Log::channel('api_wa')->error('Error API WhatsApp: ' . $decoded);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            // Handle kesalahan jika ada
            // echo 'Error: ' . $e->getMessage();
            Log::channel('api_wa')->error('Error API WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
