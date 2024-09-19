<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectController;
use App\Models\Student;
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
    Route::post('/new_student', [StudentsController::class, 'addNewStudent'])->name('add_student.create');
    Route::delete('/delete_student/{id}', [StudentsController::class, 'deleteStudent'])->name('delete_student.delete');
    
    Route::get('/all_classroom', [ClassroomController::class, 'viewAllClassroom'])->name('all_classroom');
    Route::post('/all_classroom', [ClassroomController::class, 'searchClassroomName'])->name('search_classroom');
    Route::get('/view_classroom/{id}', [ClassroomController::class, 'viewClassroomDetails'])->name('view_classroom');
    Route::get('/my_classroom', [ClassroomController::class, 'viewClassTeacherClassroom'])->name('my_classroom');
    Route::get('/add_classroom', [ClassroomController::class, 'viewAddClassroom'])->name('add_classroom');
    Route::post('/add_classroom', [ClassroomController::class, 'registerNewClassroom'])->name('add_classroom.create');
    Route::get('/edit_classroom/{id}', [ClassroomController::class, 'viewEditClassroom'])->name('edit_classroom');
    Route::delete('/delete_classrooom/{id}', [ClassroomController::class, 'deleteClassroom'])->name('delete_classroom.delete');
    Route::patch('/edit_classroom/remove_student/{id}', [ClassroomController::class, 'removeStudentClass'])->name('decrease_student.update');
    
    Route::get('/all_subject', [SubjectController::class, 'viewAllSubject'])->name('all_subjects');
    Route::get('/new_subject', [SubjectController::class, 'viewAddNewSubject'])->name('new_subject');
    Route::post('/new_subject/create', [SubjectController::class, 'createNewSubject'])->name('new_subject.create');
    Route::get('/edit_subject/{id}', [SubjectController::class, 'viewEditSubject'])->name('edit_subject');
});

require __DIR__.'/auth.php';
