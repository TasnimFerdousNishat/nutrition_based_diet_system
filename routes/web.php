<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BmiController;

use App\Http\Controllers\UserInfoController;

use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    

  


    Route::post('/bmi/store', [BmiController::class, 'store'])->name('bmi.store');

    Route::get('/bmi_calculator', [BmiController::class, 'bmi_view']);

    Route::get('/input_details', [UserInfoController::class, 'checkUserInfo']);

    Route::get('/user_input', [BmiController::class, 'input_details']);

    Route::get('/dashboard', [BmiController::class, 'showDashboard'])->name('dashboard');

    Route::get('/validation', [BmiController::class, 'validation']);

    Route::post('user_info/store',[UserInfoController::class,'store'])->name('user_info.store');




    Route::get('/register_vendor', function(){

        return view('register_vendor');
    });

    
    Route::get('/register_consultant', function(){

        return view('register_consultant');
    });




    #admin routes 

    Route::post('/admin/store-food', [AdminController::class, 'storeFoodSuggestion'])->name('admin.storeFood');

    Route::get('/admindashboard',[AdminController::class, 'view']);
   

});
