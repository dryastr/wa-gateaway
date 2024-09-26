<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Reminder: ' . $this->task->title)
            ->line('This is a reminder for your task: ' . $this->task->title)
            ->line('Description: ' . $this->task->description)
            ->line('Scheduled for: ' . $this->task->time_reminder->format('d M Y H:i'));
    }
}
