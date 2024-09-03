<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsController;
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

    Route::get('/all_teacher', [AccountController::class, 'viewAllTeacher'])->name('all_teacher');
    Route::post('/all_teacher', [AccountController::class, 'searchTeacherName'])->name('search_teacher');
    Route::get('/add_teacher', [RegisteredUserController::class, 'viewAddTeacher'])->name('add_teacher');
    Route::get('/teacher_details/{id}', [AccountController::class, 'viewTeacherDetails'])->name('view_teacher');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.create');
    Route::delete('/delete_teacher/{id}', [AccountController::class, 'destroyTeacher'])->name('delete.teacher');

    Route::get('/all_student', [StudentsController::class, 'viewAllStudent'])->name('all_student');
    Route::post('/all_student', [StudentsController::class, 'searchStudentName'])->name('search_student');
    Route::get('/add_student', [StudentsController::class, 'viewAddStudent'])->name('add_student');
    Route::get('/view_student/{id}', [StudentsController::class, 'viewStudentDetails'])->name('view_student');

});

require __DIR__.'/auth.php';
