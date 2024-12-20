<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/',[FrontendController ::class,'index'])->name('root');




//dashboard-routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

//management

Route::prefix(env('HOST_NAME'))->middleware(['rolecheck'])->group(function(){

    Route::get('/management', [ManagementController::class,'index'])->name("management.index");
    Route::post('/management/user/register', [ManagementController::class,'store_register'])->name("management.store");
    Route::post('/management/user/manager/down{id}', [ManagementController::class,'manager_down'])->name("management.down");

    //role
    Route::get('/management/role', [ManagementController::class,'role_index'])->name("management.role.index");
    Route::post('/management/role/assign', [ManagementController::class,'role_assign'])->name("management.role.assign");
    Route::post('/management/role/undo/blogger/{id}', [ManagementController::class,'blogger_grade_down'])->name("management.role.blogger.down");
    Route::post('/management/role/undo/user/{id}', [ManagementController::class,'user_grade_down'])->name("management.role.user.down");


});






//profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class,'index'])->name("profile");
Route::post('/profile/name/update', [App\Http\Controllers\ProfileController::class,'name_update'])->name("profile.name.update");
Route::post('/profile/email/update', [App\Http\Controllers\ProfileController::class,'email_update'])->name("profile.email.update");
Route::post('/profile/password/update', [App\Http\Controllers\ProfileController::class,'password_update'])->name("profile.password.update");
Route::post('/profile/image/update', [App\Http\Controllers\ProfileController::class,'image_update'])->name("profile.image.update");

//category
Route::get('/category',[CategoryController::class,'index'])->name('category.index');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::get('/category/edit/{rifat}',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/category/update/{slug}',[CategoryController::class,'update'])->name('category.update');
Route::get('/category/delete/{slug}',[CategoryController::class,'delete'])->name('category.delete');
Route::post('/category/status/{slug}',[CategoryController::class,'status'])->name('category.status');

