<?php

use App\Http\Controllers\ManageAccount;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/all_teacher', [ManageAccount::class, 'viewAllTeacher'])->name('all_teacher');
    Route::post('/all_teacher', [ManageAccount::class, 'searchTeacherName'])->name('search_teacher');
    Route::get('/add_teacher', [ManageAccount::class, 'viewAddTeacher'])->name('add_teacher');
    Route::get('/teacher_details/{id}', [ManageAccount::class, 'viewTeacherDetails'])->name('view_teacher');
});

require __DIR__.'/auth.php';
