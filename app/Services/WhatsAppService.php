<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;

class WhatsAppService
{
    private $client;
    private $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    public function sendMessage($to, $message)
    {
        try {
            $result = $this->client->messages->create(
                "whatsapp:$to",
                [
                    'from' => "whatsapp:$this->from",
                    'body' => $message
                ]
            );

            return [
                'success' => true,
                'message_id' => $result->sid
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}