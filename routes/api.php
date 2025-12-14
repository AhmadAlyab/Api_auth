<?php

use App\Http\Controllers\Api\Auth\loginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware('auth:admin')->group(function () {
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::patch('/update',[UserController::class,'update'])->name('user.update');
    Route::delete('/delete/{id}',[UserController::class,'destroy'])->name('user.delete');
});


Route::post('/reset',[ResetPasswordController::class,'reset'])->name('resetpassword');
Route::post('/register',[RegisterController::class,'register'])->name('register');
Route::post('/login',[loginController::class,'login'])->name('login');
