<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BmiRecord;
use App\Models\UserInfo;
use App\Models\FoodSuggestion;
use Auth;
use Carbon\Carbon;




class BmiController extends Controller
{
    public function validation(Request $request)
{
    $userId = Auth::id();

    $today = Carbon::today();

    $existingRecord = BmiRecord::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->first();

    if ($existingRecord) {
        return response()->json(['status' => 'error', 'message' => 'You can only calculate BMI once per day.']);
    }
    return response()->json(['status' => 'success']);
}

public function store(Request $request)
{
    $request->validate([
        'height' => 'required|numeric|min:30|max:300',
        'weight' => 'required|numeric|min:10|max:500',
    ]);

    $userId = Auth::id();
    $height = $request->height / 100;
    $weight = $request->weight;
    $bmi = $weight / ($height * $height);

    BmiRecord::create([
        'user_id' => $userId,
        'height' => $request->height,
        'weight' => $request->weight,
        'bmi' => $bmi,
    ]);

    return redirect('/dashboard');
}

    public function showDashboard()
    {
        $userId = Auth::id();

        $bmiRecords = BmiRecord::where('user_id', $userId)->orderBy('created_at')->get();

        $bmi = BmiRecord::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('bmi');


        if($bmi<18.5 && $bmi>0){

            $bmi_cond = "UnderWeight";

            $food_suggestion_data = FoodSuggestion::whereJsonContains('bmi_levels', 'Underweight')->get();

            return view('dashboard', compact('bmiRecords','food_suggestion_data','bmi_cond'));

        }


        elseif ($bmi>18.5 && $bmi<24.9) {

            $bmi_cond = "Normal";
            
            $food_suggestion_data = FoodSuggestion::whereJsonContains('bmi_levels', 'Normal')->get();

            return view('dashboard', compact('bmiRecords','food_suggestion_data','bmi_cond'));
        }


        elseif($bmi>25 && $bmi<29.9){


            $bmi_cond = "Overweight";

            $food_suggestion_data = FoodSuggestion::whereJsonContains('bmi_levels', 'Overweight')->get();

            return view('dashboard', compact('bmiRecords','food_suggestion_data','bmi_cond'));

            
        }


        elseif ($bmi>30) {

            $bmi_cond= "Obese";


            $food_suggestion_data = FoodSuggestion::whereJsonContains('bmi_levels', 'Obese')->get();

            return view('dashboard', compact('bmiRecords','food_suggestion_data','bmi_cond'));
          
        }


        
    }

    public function bmi_view()
    {
        return view('bmi_calculator');
    }


    public  function input_details()
    {

        return view('input_details');
    } 

    
}
