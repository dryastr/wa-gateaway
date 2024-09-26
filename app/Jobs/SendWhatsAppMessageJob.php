<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($taskTitle)
    {
        $this->taskTitle = $taskTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Hardcoded phone number for now
        $phoneNumber = '6285161206235';

        // Send WhatsApp notification logic (using whatsapp-web.js)
        $message = "Reminder: Task '{$this->taskTitle}' is scheduled now.";

        $client = new \GuzzleHttp\Client();
        $client->post('http://localhost:3000/send-message', [
            'json' => [
                'phone' => $phoneNumber,
                'message' => $message,
            ]
        ]);

        // Alternatively, you can use any other WhatsApp API provider here
    }
}
