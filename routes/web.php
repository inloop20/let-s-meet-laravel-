<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

;

Route::get('/login',[AuthController::class,'getAuth'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
Route::post('/register',[AuthController::class,'register'])->name('auth.register');

Route::get('/',[EventController::class,'getEvents'])->name('getEvents');
Route::get('/events',[EventController::class,'allEvents'])->name('allEvents');

Route::middleware('auth')->group(function(){   
    Route::post('/logout',[AuthController::class,'logout'])->name('auth.logout');

    Route::get('/profile',[ProfileController::class,'edit'])->name('profile');
    Route::put('/profile',[ProfileController::class,'update'])->name('profile.update');
    
    Route::get('/check-in/{event}/{user}',[EventController::class,'checkin'])->name('checkin');

    Route::get('/events/create',[EventController::class,'create'])->name('event.create');
    Route::post('/events',[EventController::class,'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');

    Route::get('/my-events',[EventController::class,'myEvents'])->name('myEvents');
    Route::post('/event-register/{event}',[EventController::class,'register'])->name('event.register');
    
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
});
