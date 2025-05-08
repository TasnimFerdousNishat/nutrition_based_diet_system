<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineSchedule;
use Carbon\Carbon;

class MedicineController extends Controller
{
    public function index()
    {
        $schedules = MedicineSchedule::where('user_id', auth()->id())->orderBy('schedule_time')->get();

        return view('medicine_schedule', compact('schedules'));
    }

    public function store(Request $request)
    {
        foreach ($request->medicine as $index => $medicine) {
            MedicineSchedule::create([
                'user_id' => auth()->id(),
                'medicine_name' => $medicine,
                'schedule_time' => $request->schedule_time[$index]
            ]);
        }

        $schedules = MedicineSchedule::where('user_id', auth()->id())->orderBy('schedule_time')->get()
                    ->map(function ($item) {
                        return [
                            'medicine_name' => $item->medicine_name,
                            'schedule_time' => Carbon::parse($item->schedule_time)->format('h:i A')
                        ];
                    });

        return response()->json(['schedules' => $schedules]);
    }
}
