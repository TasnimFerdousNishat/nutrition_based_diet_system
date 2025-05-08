<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MedicineSchedule;
use App\Models\Consultant2;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $userId = Auth::id();

            $is_consultant = Consultant2::where('user_id', Auth::id())->first();

            $now = Carbon::now('Asia/Dhaka'); // Ensure timezone is consistent

            $schedules = MedicineSchedule::where('user_id', $userId)->get();

            $upcoming_medicines = $schedules->filter(function ($medicine) use ($now) {
                $scheduleTime = Carbon::parse($medicine->schedule_time)->setTimezone('Asia/Dhaka'); // Ensure schedule time is in the same timezone
                $diff = $now->diffInMinutes($scheduleTime, false); // Get the difference, allowing negative values
                return $diff >= 0 && $diff <= 15; // Check if within the next 15 minutes
            });

            $view->with([
    'upcoming_medicines' => $upcoming_medicines,
    'is_consultant' => $is_consultant,
]);
        } else {
            $view->with('upcoming_medicines', collect());
        }

        
    });
}

}
