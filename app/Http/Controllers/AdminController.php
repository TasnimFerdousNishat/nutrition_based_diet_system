<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodSuggestion;
use App\Models\FoodItem;
use App\Models\FestiveFood;
Use App\Models\Consultant2;
Use App\Models\Exercise;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function view()
    {
        $total_users = User::count();

        $consultant_request = Consultant2::where('approved', '0')->count();
        
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

            return view('admin.admindashboard', compact('total_users','consultant_request', 'months', 'userCounts'));

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


    public function add_food_recipe(){


        return view('admin/food_recipe');
    }

    public function c_req_view()
    {
        $req_data = Consultant2::where('approved', 0)->paginate(6); 
        return view('admin.approve_consultant', compact('req_data'));
    }
    

public function approveConsultant($id)
{
    $consultant = Consultant2::findOrFail($id);
    $consultant->approved = 1;
    $consultant->save();

    return redirect()->back()->with('success', 'Consultant approved successfully.');
}

public function deleteConsultant($id)
{
    $consultant = Consultant2::findOrFail($id);
    $consultant->delete();

    return redirect()->back()->with('success', 'Consultant deleted successfully.');
}




public function storeFoodShop(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'bmi_levels' => 'required|array',
        'meal_time' => 'required|string',
        'nutrition_info2' => 'nullable|array',
        'photo' => 'required|image',
        'price' => 'required|numeric',
        'description' => 'required|string',
    ]);

    $photoPath = $request->file('photo')->store('food_photos', 'public');

    FoodItem::create([
        'name' => $request->name,
        'bmi_levels' => $request->bmi_levels,
        'meal_time' => $request->meal_time,
        'nutrition_info' => $request->nutrition_info2,
        'photo' => $photoPath,
        'price' => $request->price,
        'description' => $request->description,
    ]);

    return redirect('/admindashboard');
}


public function storeExcercise(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bmi_levels' => 'required|array',
            'excercise_time' => 'required|string',
            'excercise_outcome' => 'nullable|array',
            'photo' => 'nullable|image|max:2048',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'description' => 'required|string',
        ]);
    
        // Combine hours and minutes into time format
        $duration = sprintf('%02d:%02d:00', $validated['hours'], $validated['minutes']);
    
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('exercise_photos', 'public');
        }
    
        Exercise::create([
            'name' => $validated['name'],
            'bmi_levels' => $validated['bmi_levels'],
            'excercise_time' => $validated['excercise_time'],
            'excercise_outcome' => $validated['excercise_outcome'] ?? [],
            'photo' => $validated['photo'] ?? null,
            'duration' => $duration,
            'description' => $validated['description'],
        ]);
    
        return back()->with('success', 'Exercise added successfully!');
    }



    public function storeFestiveFood(Request $request){


        $request->validate([
            'name' => 'required|string|max:255',
            'festname' => 'required|string|max:255',
            'bmi_levels' => 'nullable|array',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ingredients2' => 'nullable|array',
            'description' => 'required|string',
        ]);

        // Handle photo upload
        $photoPath = $request->file('photo')->store('festive_photos', 'public');

        FestiveFood::create([
            'name' => $request->name,
            'festname' => $request->festname,
            'bmi_levels' => $request->bmi_levels,
            'photo' => $photoPath,
            'ingredients' => $request->ingredients2,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Festive food added successfully!');



    }


}
