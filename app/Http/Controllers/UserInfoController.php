<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{

    public function checkUserInfo(Request $request)
    {
        $user_id = Auth::id();
    
        $existrecord = UserInfo::where('user_id', $user_id)->first();
    
        if ($existrecord) {
            return redirect('/dashboard')->with('error', 'You have already added your information. Edit Information will be available in the future.');
        }
    
        return redirect('/user_input');
    }
    


    public function store(Request $request)
{
    
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'User not authenticated!');
    }

  
    $request->validate([
        'birthday' => 'required|date',
        'gender' => 'required',
        'address' => 'required|string',
        'contact' => 'nullable|string',
        'em_contact' => 'nullable|string',
        'diabetes' => 'required|string',
        'menstrual_cycle' => 'nullable|string',
        'description' => 'nullable|string'
    ]);

   
    $userInfo = UserInfo::create([
        'user_id' => Auth::id(),
        'birthday' => $request->birthday,
        'gender' => $request->gender,
        'address' => $request->address,
        'contact' => $request->contact,
        'em_contact' => $request->em_contact,
        'diabetes' => $request->diabetes,
        'menstrual_cycle' => $request->menstrual_cycle,
        'description' => $request->description,
    ]);

  
    if (!$userInfo) {
        return redirect()->back()->with('error', 'Failed to save user info!');
    }

    return redirect('/dashboard')->with('success', 'Added successfully!');
}

}
