<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeeTimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GolfCourseController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/courses', [GolfCourseController::class, 'index'])->name('courses.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tee-times/create', [TeeTimeController::class, 'create'])->name('tee-times.create');
    
    Route::post('/tee-times', [TeeTimeController::class, 'store'])->name('tee-times.store');
    
    Route::post('/tee-times/{teeTime}/join', [TeeTimeController::class, 'join'])->name('tee-times.join');
    
    Route::post('/tee-times/{teeTime}/leave', [TeeTimeController::class, 'leave'])->name('tee-times.leave');
    
    Route::get('/tee-times/joinable', [TeeTimeController::class, 'joinable'])->name('tee-times.joinable');

    Route::get('/tee-times/mine', [TeeTimeController::class, 'mine'])->name('tee-times.mine');

    Route::delete('/tee-times/{teeTime}', [TeeTimeController::class, 'destroy'])->name('tee-times.destroy');
});

require __DIR__.'/auth.php';
