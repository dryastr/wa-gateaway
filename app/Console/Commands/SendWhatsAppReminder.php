<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;
use App\Jobs\SendWhatsAppMessageJob;

class SendWhatsAppReminder extends Command
{
    protected $signature = 'send:whatsapp-reminder';
    protected $description = 'Send WhatsApp reminders for upcoming tasks';

    public function handle()
    {
        // Mengambil semua tugas dengan deadline dalam waktu 3 hari
        $tasks = Task::where('time_reminder', '<=', Carbon::now())->get();

        // Hardcode nomor tujuan
        $recipientNumber = '6285161206235';

        foreach ($tasks as $task) {
            $message = "Halo, tugas kamu dengan judul '{$task->title}' akan jatuh tempo pada {$task->deadline}. Harap segera dikerjakan.";

            // Menambahkan nomor tujuan ke dalam job
            SendWhatsAppMessageJob::dispatch($recipientNumber, $message);
        }

        return 0;
    }
}
