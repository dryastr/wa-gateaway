<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class SendTaskReminder extends Command
{
    protected $signature = 'task:send-reminder';
    protected $description = 'Send WhatsApp reminders for tasks nearing their deadline';

    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        parent::__construct();
        $this->whatsAppService = $whatsAppService;
    }

    public function handle()
    {
        // Ambil semua tugas
        $tasks = Task::whereNotNull('time_reminder')->get();

        foreach ($tasks as $task) {
            // Menghitung tanggal untuk pengingat
            $reminderDate = Carbon::parse($task->time_reminder);

            // Cek apakah hari ini sama dengan tanggal pengingat
            if ($reminderDate->isToday()) {
                $this->whatsAppService->sendMessage(
                    '+6285156030568', // Nomor tujuan
                    "Pengingat: Tugas \"{$task->title}\" akan jatuh tempo pada {$task->deadline}. Harap segera dikerjakan!"
                );
            }
        }

        $this->info('Reminder notifications sent successfully.');
    }
}
