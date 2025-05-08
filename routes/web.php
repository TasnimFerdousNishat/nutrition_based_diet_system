<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BmiController;

use App\Http\Controllers\UserInfoController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\FoodController;

Use App\Http\Controllers\ConsultantController;

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\MedicineController;

use App\Http\Controllers\OrderController;

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


 

    Route::get('/my-orders', [OrderController::class, 'userApprovedOrders'])->name('user.orders');
    Route::post('/order/delivered/{id}', [OrderController::class, 'markAsDelivered'])->name('order.delivered');
    Route::post('/order/{id}/mark-delivered', [OrderController::class, 'markAsDelivered'])->name('order.mark.delivered');




    

    Route:: get('food_details/show/{id}',[BmiController::class, 'food_details']);



    Route::get('/register_vendor', function(){

        return view('register_vendor');
    });

    
    Route::get('/register_consultant', function(){

        return view('register_consultant');
    });




    #admin routes 

    Route::post('/admin/store-food', [AdminController::class, 'storeFoodSuggestion'])->name('admin.storeFood');

    Route::post('/admin/store-food2', [AdminController::class, 'storeFoodShop'])->name('admin.storeFood2');

    Route::get('/admindashboard',[AdminController::class, 'view']);

    Route::get('/add_food_recipe',[AdminController::class, 'add_food_recipe']);

    Route::post('/add-recipe', [RecipeController::class, 'store'])->name('recipes.store');

    Route::get('/approve_consultant', [AdminController::class, 'c_req_view']);

    Route::get('/admin/consultant/approve/{id}', [AdminController::class, 'approveConsultant'])->name('consultant.approve');
    
    Route::get('/admin/consultant/delete/{id}', [AdminController::class, 'deleteConsultant'])->name('consultant.delete');

    Route::post('/exercise/store', [AdminController::class, 'storeExcercise'])->name('exercise.store');

    Route::get('/exercises', [BmiController::class, 'show_exer'])->name('exercise.show');


    Route::post('/festive_food/store', [AdminController::class, 'storeFestiveFood'])->name('festivefood.store');

    Route::get('/admin/orders/pending', [OrderController::class, 'pendingOrders']);

    Route::get('/admin/orders/approved', [OrderController::class, 'approvedOrders']);

    Route::post('/admin/orders/approve/{id}', [OrderController::class, 'approveOrder']);




    #store:

    Route::get('/foods', [FoodController::class, 'view'])->name('foods');


    Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');


    Route::get('/menu', [OrderController::class, 'showMenu'])->name('menu');
    
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');

    Route::get('/other_diet',[BmiController::class, 'other_diet'])->name('other_diet');

    Route::get('/festive-food/{id}', [BmiController::class, 'show']);




    #Medicine
    Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine.index');
    Route::post('/medicine/store', [MedicineController::class, 'store'])->name('medicine.store');

    Route::post('/consultant/store', [ConsultantController::class, 'store'])->name('consultant.store');
   

});
