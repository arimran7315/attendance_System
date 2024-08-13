<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home')->middleware(ValidUser::class);
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register',function(){
    return view('signup');
})->name('register');

Route::post('/loginfunction', [UserController::class, 'signin'])->name('loginfunction');
Route::get('/logout',[UserController::class, 'logout'])->name('logout');
Route::post('/signup', [UserController::class, 'signup'])->name('signup');
Route::resource('/attendance', AttendanceController::class);
Route::get('/reportAll', [AttendanceController::class, 'reportAll'])->name('attendance.reportAll');
Route::get('/report', [AttendanceController::class, 'report'])->name('attendance.report');

Route::get('/index',[UserController::class, 'home'])->name('index');