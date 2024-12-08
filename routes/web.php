<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectController;
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
    Route::get('/all_teacher/search', [AccountController::class, 'searchTeacherName'])->name('search_teacher');
    Route::get('/add_teacher', [RegisteredUserController::class, 'viewAddTeacher'])->name('add_teacher');
    Route::get('/teacher_details/{id}', [AccountController::class, 'viewTeacherDetails'])->name('view_teacher');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.create');
    Route::delete('/delete_teacher/{id}', [AccountController::class, 'destroyTeacher'])->name('delete.teacher');
    Route::post('import-csv', [AccountController::class, 'importUser'])->name('import.teacher');

    Route::get('/all_student', [StudentsController::class, 'viewAllStudent'])->name('all_student');
    Route::get('/all_student/search', [StudentsController::class, 'searchStudentName'])->name('search_student');
    Route::get('/all_student/filter', [StudentsController::class, 'filterStudent'])->name('filter_student');
    Route::get('/add_student', [StudentsController::class, 'viewAddStudent'])->name('add_student');
    Route::get('/view_student/{id}', [StudentsController::class, 'viewStudentDetails'])->name('view_student');
    Route::get('/edit_student/{id}', [StudentsController::class, 'viewEditStudent'])->name('edit_student');
    Route::post('/new_student', [StudentsController::class, 'addNewStudent'])->name('add_student.create');
    Route::patch('/student_classroom/{id}', [StudentsController::class, 'registerStudentClass'])->name('edit_student.add_class');
    Route::delete('/delete_student/{id}', [StudentsController::class, 'deleteStudent'])->name('delete_student.delete');
    Route::post('/view_student/{id}/transition', [StudentsController::class, 'addStudentTranstion'])->name('transition_student.create');
    Route::put('/edit_student/{id}/update', [StudentsController::class, 'updateStudentInfo'])->name('edit_student.update');
    
    Route::get('/all_classroom', [ClassroomController::class, 'viewAllClassroom'])->name('all_classroom');
    Route::get('/all_classroom/search', [ClassroomController::class, 'searchClassroomName'])->name('search_classroom');
    Route::get('/view_classroom/{id}', [ClassroomController::class, 'viewClassroomDetails'])->name('view_classroom');
    Route::get('/my_classroom', [ClassroomController::class, 'viewClassTeacherClassroom'])->name('my_classroom');
    Route::get('/add_classroom', [ClassroomController::class, 'viewAddClassroom'])->name('add_classroom');
    Route::post('/add_classroom', [ClassroomController::class, 'registerNewClassroom'])->name('add_classroom.create');
    Route::get('/edit_classroom/{id}', [ClassroomController::class, 'viewEditClassroom'])->name('edit_classroom');
    Route::patch('/update_info/{id}', [ClassroomController::class, 'updateClassroomInfo'])->name('update_classroom.update');
    Route::delete('/delete_classrooom/{id}', [ClassroomController::class, 'deleteClassroom'])->name('delete_classroom.delete');
    Route::patch('/edit_classroom/remove_student/{id}', [ClassroomController::class, 'removeStudentClass'])->name('decrease_student.update');
    
    Route::get('/all_subject', [SubjectController::class, 'viewAllSubject'])->name('all_subjects');
    Route::get('/new_subject', [SubjectController::class, 'viewAddNewSubject'])->name('new_subject');
    Route::post('/new_subject/create', [SubjectController::class, 'createNewSubject'])->name('new_subject.create');
    Route::get('/edit_subject/{id}', [SubjectController::class, 'viewEditSubject'])->name('edit_subject');
    Route::patch('/edit_subject/{id}/update_info', [SubjectController::class, 'updateSubjectInfo'])->name('update_subject.update');
    Route::delete('/delete_subject/{id}', [SubjectController::class, 'deleteSubject'])->name('delete_subject.delete');
    Route::post('/edit_subject/{id}/add_teacher', [SubjectController::class, 'addSubjectTeacher'])->name('edit_subject.add_teacher');
    Route::delete('/edit_subject/drop_teacher/{id}/{teacher_id}', [SubjectController::class, 'dropSubjectTeacher'])->name('edit_subject.drop_teacher');
    Route::get('/view_classroom/{id}/subject_registered', [SubjectController::class, 'viewclassroomsubject'])->name('class_subject');
    Route::post('/subject_registered/new_subject/{id}', [SubjectController::class, 'addSubjectClass'])->name('add.class_subject');
    Route::put('/subject_registered/new_teacher', [SubjectController::class, 'changeSubjectTeacher'])->name('edit.classsubject_teacher');
    Route::delete('/subject_registered/drop_subject/{id}/{class_id}', [SubjectController::class, 'dropClassroomSubject'])->name('edit.dropclassroom_subject');
    Route::get('/view_student/{id}/subject_taken', [SubjectController::class, 'viewStudentSubject'])->name('student_subject');
    Route::get('/view_student/{id}/add_elective_subject', [SubjectController::class, 'addStudentElectiveSubject'])->name('add.studentelective_subject');
    Route::delete('/view_student/{id}/drop_elective_subject/{subs_id}', [SubjectController::class, 'dropStudentElectiveSubject'])->name('drop.studentelective_subject');

    Route::get('/all_examination', [ExaminationController::class, 'viewAllExamination'])->name('all_examination');
    Route::get('/add_examination', [ExaminationController::class, 'viewAddExamination'])->name('add_examination');
    Route::get('/all_examination/search', [ExaminationController::class, 'searchExamination'])->name('search_examination');
    Route::get('/all_student-examination', [ExaminationController::class, 'viewStudentExamination'])->name('student_examination');
    Route::get('/all_student-examination/search', [ExaminationController::class, 'searchStudentExamination'])->name('search_studentexam');
    Route::get('/examination_details/{id}', [ExaminationController::class, 'viewExaminationDetails'])->name('view_examination');
    Route::get('/all_examination/filter', [ExaminationController::class, 'filterExamination'])->name('filter_examination');
    Route::get('/class_examination/{id}', [ExaminationController::class, 'viewClassExamination'])->name('view_classexam');
    Route::get('/students_exam_mark/class={class_id}&subject={subject_id}&exam={exam_id}', [ExaminationController::class, 'viewClassroomExamMark'])->name('students_exam_mark');
    Route::get('/registered_exam_marks/class={class_id}&subject={subject_id}&exam={exam_id}', [ExaminationController::class, 'viewRegisteredExamMark'])->name('registered_exam_marks');
    Route::post('/add_examination/create', [ExaminationController::class, 'addNewExamination'])->name('create.add_examination');
    Route::patch('/examination_details/update/{id}', [ExaminationController::class, 'updateExaminationDetails'])->name('update.view_examination');
    Route::delete('/examination_details/delete/{id}', [ExaminationController::class, 'deleteExamination'])->name('delete.view_examination');
    Route::put('/examination_details/release/{id}', [ExaminationController::class, 'releaseExamination'])->name('update_release.view_examination');
    Route::post('/add_student_exam_mark/create', [ExaminationController::class, 'addStudentExamMark'])->name('add_exam_mark.create');
    Route::patch('/update_student_exam_mark/update', [ExaminationController::class, 'updateStudentsExamMarks'])->name('update_exam_mark.update');
    
    Route::get('/exam_feedback/class={class_id}&subject={subject_id}&exam={exam_id}', [FeedbackController::class, 'viewClassroomFeedback'])->name('exam_mark_feedbacks');
    Route::get('/examination={id}/my-class-feed', [FeedbackController::class, 'viewMyClassFeed'])->name('myclass_exam-feed');
    Route::patch('/update/student-feedback', [FeedbackController::class, 'manageStudentFeedback'])->name('studente-feedback.update');
    Route::get('performance_feedback/examination={examID}/student_id={stdID}', [FeedbackController::class, 'viewStudentPerformanceFeedback'])->name('student_ferformance.feedback');
    Route::patch('performance_feedback/update-feedback/{id}', [FeedbackController::class, 'addExamReportFeedback'])->name('student_ferformance.update_feedback');

    Route::get('/all_report/{id}', [ReportController::class, 'viewAllReport'])->name('all_report');
    Route::get('/all_report/subject_report/examination={id}', [ReportController::class, 'viewSubjectReport'])->name('subject_report');
    Route::get('/all_report/classroom_report/examination={id}', [ReportController::class, 'viewClassroomReport'])->name('classroom_report');
    Route::get('/all_report/form_report/examination={id}', [ReportController::class, 'viewFormReport'])->name('form_report');
    Route::get('/all_report/class_recomendation_report/examination={id}', [ReportController::class, 'viewClassRecomendationReport'])->name('classrec_report');
    Route::get('/all_report/student_report/examination={examReport}/student={stdID}', [ReportController::class, 'viewStudentReport'])->name('performance_report');
    Route::get('/download_student_report/examination={exam}/student={stdID}', [ReportController::class, 'downloadExamResult'])->name('download_report');
});

require __DIR__.'/auth.php';
