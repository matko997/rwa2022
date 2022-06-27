<?php

use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\PatientController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\Admin\DashboardController;
use \App\Http\Controllers\Admin\DoctorController;
use \App\Http\Controllers\Admin\ScheduleController;
use \App\Http\Controllers\Admin\ServiceController;
use \App\Http\Controllers\Admin\AppointmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home page routes

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get("/about",[HomeController::class,'about'])->name('about');


Route::get('/signup',[SignupController::class,'create'])->name('signupForm')->middleware('guest');
Route::post('/signup',[SignupController::class,'store'])->name('signup')->middleware('guest');


Route::get('/login',[SessionsController::class,'create'])->name('loginForm')->middleware('guest');
Route::post('/login',[SessionsController::class,'store'])->name('login')->middleware('guest');

Route::post('/logout',[SessionsController::class,'destroy'])->name('logout')->middleware('auth');


//Admin routes
Route::prefix('admin')->name('admin.')->group(function()
{
    Route::resource('/patient',PatientController::class);
    Route::resource('/doctor',DoctorController::class);
    Route::resource('/schedule',ScheduleController::class);
    Route::resource('/service',ServiceController::class);
    Route::resource('/appointment',AppointmentController::class);
    Route::post('/appointment/store',[AppointmentController::class,'store'])->name('appointment.store');
    Route::post('/appointment/getDoctorId',[AppointmentController::class,'getDoctorId'])->name('appointment.getDoctorId');
    Route::get('/dashboard',[DashboardController::class,'index']);

});


