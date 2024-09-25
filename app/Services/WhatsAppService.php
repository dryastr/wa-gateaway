<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    public function sendMessage($to, $message)
    {
        return $this->twilio->messages->create(
            "whatsapp:$to",
            [
                'from' => env('TWILIO_FROM'),
                'body' => $message,
            ]
        );
    }
}
