<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Consultant2;
use Illuminate\Support\Facades\Auth;


class ConsultantController extends Controller
{



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'nid' => 'required|string',
        'address' => 'required|string',
        'contact' => 'nullable|string',
        'em_contact' => 'nullable|string',
        'birthday' => 'required|date',
        'gender' => 'required|in:male,female,other',
        'license_photo' => 'required|image',
        'cv' => 'required|file',
        'description' => 'nullable|string',
    ]);

    $licensePath = $request->file('license_photo')->store('licenses', 'public');
    $cvPath = $request->file('cv')->store('cvs', 'public');

    Consultant2::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'nid' => $request->nid,
        'address' => $request->address,
        'contact' => $request->contact,
        'em_contact' => $request->em_contact,
        'birthday' => $request->birthday,
        'gender' => $request->gender,
        'license_photo' => $licensePath,
        'cv' => $cvPath,
        'description' => $request->description,
    ]);

    return redirect('/dashboard')->with('success', 'Consultant profile created successfully.');
}

}
