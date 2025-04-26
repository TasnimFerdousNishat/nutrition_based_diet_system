<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recipe;

class FoodController extends Controller
{
    public function view(Request $request)
    {
        $search = trim($request->input('search'));
    
        if (!empty($search)) {
            $recipes = Recipe::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $recipes = Recipe::all();
        }
    
        return view('food_store.foods', compact('recipes'));
    }
    

}
