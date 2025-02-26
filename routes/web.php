<?php

use App\Http\Controllers\ProfileController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $courses = Course::all();
    return view('home', get_defined_vars());
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
