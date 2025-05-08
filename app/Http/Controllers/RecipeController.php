<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'food_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'calories' => 'nullable|integer',
        'nutrition_info' => 'nullable|array',
        'ingredients' => 'nullable|array',
        'bmi_levels' => 'nullable|array',
        'description' => 'nullable|string',
    ]);

    $imagePath = null;

    if ($request->hasFile('food_photo')) {
        
        $imagePath = $request->file('food_photo')->store('recipes', 'public');
    }

    Recipe::create([
        'name' => $request->name,
        'food_photo' => $imagePath, 
        'calories' => $request->calories,
        'nutrition_info' => $request->nutrition_info,
        'ingredients' => $request->ingredients,
        'bmi_levels' => $request->bmi_levels,
        'description' => $request->description,
    ]);

    return redirect('/admindashboard');
}


public function show($id)
{
    $recipe = Recipe::findOrFail($id);

    return view('recipe_details', compact('recipe'));
}

}
