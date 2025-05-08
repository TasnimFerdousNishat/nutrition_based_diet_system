<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Medicine;
use App\Notifications\MedicineReminder;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $now = now()->format('H:i');

        $medicines = Medicine::where('schedule_time', $now)->get();

        foreach ($medicines as $medicine) {
            $user = $medicine->user;

            // Prevent duplicate reminders per day
            $alreadyNotified = $user->notifications()
                ->where('data->message', "Time to take your medicine: {$medicine->name}")
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (!$alreadyNotified) {
                $user->notify(new MedicineReminder($medicine));
            }
        }
    })->everyMinute();
}

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
