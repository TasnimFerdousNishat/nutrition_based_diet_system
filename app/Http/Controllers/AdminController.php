<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodSuggestion;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function view()
    {
        $total_users = User::count();
        
        $user_id = Auth::id(); 

        $user_type = User::where('id', $user_id)->value('user_type');

        if ($user_type == '1') {
         
            $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            
            $months = [];
            $userCounts = [];

            for ($i = 1; $i <= 12; $i++) {

                $months[] = date("F", mktime(0, 0, 0, $i, 1)); 

                $userCounts[] = $usersPerMonth[$i] ?? 0; 
            }

            return view('admin.admindashboard', compact('total_users', 'months', 'userCounts'));

        } else {

            return redirect('/dashboard')->with('error', "You don't have access to this page.");
        }
    }


    public function storeFoodSuggestion(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'bmi_levels' => 'required|array',
            'meal_time' => 'required|string',
            'nutrition_info' => 'required|array',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        $photoPath = $request->file('photo')->store('meals', 'public');

        FoodSuggestion::create([

            'name' => $request->name,

            'ingredients' => json_encode($request->ingredients),

            'bmi_levels' => json_encode($request->bmi_levels),

            'meal_time' => $request->meal_time,

            'nutrition_info' => json_encode($request->nutrition_info),

            'photo' => $photoPath,

            'description' => $request->description,
            
        ]);


        return redirect('/admindashboard');
    }


}
