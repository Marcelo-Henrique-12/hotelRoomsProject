<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware('auth')->group(function () {


    Route::get('/', function () {
        return Inertia::render('Index');
    })->name('index');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('hotels', HotelController::class);
    Route::resource('rooms', RoomController::class);
});

require __DIR__ . '/auth.php';
