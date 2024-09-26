<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskReminder;

class SendTaskReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send task reminders';

    public function handle()
    {
        $tasks = Task::where('time_reminder', '<=', now())->get();

        foreach ($tasks as $task) {
            // Kirim notifikasi
            Notification::route('mail', 'davidsatyawibisono01@gmail.com') // Ganti dengan email yang sesuai
                ->notify(new TaskReminder($task));

            // Anda dapat menambahkan logika untuk menandai tugas sebagai sudah diingat jika diperlukan
        }

        $this->info('Task reminders sent successfully.');
    }
}
