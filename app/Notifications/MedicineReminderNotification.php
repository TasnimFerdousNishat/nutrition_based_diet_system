<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class MedicineReminder extends Notification
{
    use Queueable;

    public $medicine;

    public function __construct($medicine)
    {
        $this->medicine = $medicine;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Time to take your medicine: {$this->medicine->name}",
            'time' => now()->format('g:i A'),
        ];
    }
}
