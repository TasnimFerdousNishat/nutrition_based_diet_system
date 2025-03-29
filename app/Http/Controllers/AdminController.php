<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function view()
    {
        $total_users = User::count();

        $user_id = Auth::id();  

        $user_type = User::where('id', $user_id)->value('user_type');

        if ($user_type == '1') {
            
            return view('admin.admindashboard', compact('total_users'));
        } else {
            return redirect('/dashboard')->with('error', "You don't have access to this page.");
        }
    }
}
