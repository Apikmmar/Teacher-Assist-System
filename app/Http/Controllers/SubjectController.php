<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSubjectRequest;
use App\Http\Requests\UpdateSubjectInfoRequest;
use App\Models\Classroom;
use App\Models\Form;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Subject_Taken;
use App\Models\Subject_Teacher;
use App\Models\User;
use \Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function viewAllSubject(Request $request): View {
        if($request->subject_form != '') {
            $subjects = Subject::where('form_id', $request->subject_form)->orderBy('name')->paginate(10);
        } else {
            $subjects = Subject::orderBy('name')->paginate(10);
        }

        return view('manageSubject.all_subjects', [
            'subjects' => $subjects,
            'forms' => Form::all(),
        ]);
    }

    public function viewAddNewSubject(): View {
        $teachers = User::all();
        $teachers = $this->convertTeacherNameFormat($teachers);

        $teacherSelected = [];

        return view('manageSubject.add_subject', [
            'teachers' => $teachers,
            'forms' => Form::all(),
            'teacherSelected' => $teacherSelected
        ]);
    }

    public function viewEditSubject($id): View {
        $subject = Subject::findOrFail($id);
        $teachers = $subject->teachers;

        $teachers = $this->convertTeacherNameFormat($subject->teachers);

        $assignedTeacherIds = $teachers->pluck('id')->toArray();
        $newTeachers = User::whereNotIn('id', $assignedTeacherIds)->get();

        $newTeachers = $this->convertTeacherNameFormat($newTeachers);

        return view('manageSubject.edit_subject', [
            'subject' => $subject,
            'forms' => Form::all(),
            'teachers' => $teachers,
            'newTeachers' => $newTeachers,
        ]);
    }

    public function viewclassroomsubject($id): View {

        $teacherNames = [];
        $registeredTeachers = [];
        $notRegisteredTeachers = [];
        
        $class = Classroom::findOrFail($id);
        $subjectsTaken = Subject_Taken::where('classroom_id', $id)->get();
        $allSubjects = Subject::all();
    
        $subjectsTakenIds = $subjectsTaken->pluck('subject_id')->toArray();
        $subjectsNotTaken = $allSubjects->whereNotIn('id', $subjectsTakenIds)->where('form_id', $class->form_id);
    
        foreach ($subjectsTaken as $subject) {
            if ($subject->subject != NULL) {
                $subject->subject->name = Str::title($subject->subject->name);
            } else {
                $subject->subject->name = 'N/A';
            }
    
            if ($subject->subjectTeacher !== NULL) {
                $teacher = $subject->subjectTeacher->teacher;
                $teacherNames[$subject->id] = $this->convertTeacherNameFormat($teacher);

            } else {
                $teacherNames[$subject->id] = 'Not Assigned Yet';
            }
    
            $registeredTeachers[$subject->id] = Subject_Teacher::where('subject_id', $subject->subject->id)->get();
    
            foreach ($registeredTeachers[$subject->id] as $teacher) {
                $teacher = $teacher->teacher;
    
                if (strtolower($teacher->gender) == 'men') {
                    $teacher->name = 'Mr. ' . Str::title($teacher->name);
                } else {
                    $teacher->name = 'Mrs. ' . Str::title($teacher->name);
                }
            }
        }

        foreach ($subjectsNotTaken as $subject) {
            $notRegisteredTeachers[$subject->id] = Subject_Teacher::where('subject_id', $subject->id)->get();

            foreach ($notRegisteredTeachers[$subject->id] as $teacher) {
                $teacher = $teacher->teacher;
    
                if (strtolower($teacher->gender) == 'men') {
                    $teacher->name = 'Mr. ' . Str::title($teacher->name);
                } else {
                    $teacher->name = 'Mrs. ' . Str::title($teacher->name);
                }
            }
        }
        
        return view('manageSubject.classroom_subject', [
            'class' => $class,
            'subjectsTaken' => $subjectsTaken,
            'teacherNames' => $teacherNames,
            'registeredTeachers' => $registeredTeachers,
            'subjectsNotTaken' => $subjectsNotTaken,
            'notRegisteredTeachers' => $notRegisteredTeachers,
        ]);
    }

    public function viewStudentSubject($id): View {
        $student = Student::findOrFail($id);
        $class = Classroom::findOrFail($student->classroom_id);
        $allSubjects = Subject_Taken::where('classroom_id', $class->id)->orWhere('student_id', $student->id)->get();

        $subsTaken = [];

        foreach ($allSubjects as $subject) {
            if ($subject->subject != NULL) {
                $subsTaken[] = Str::title($subject->subject->name);
            } else {
                $subsTaken[] = 'N/A';
            }
        }
        $subsTaken = collect($subsTaken);

        return view('manageSubject.student_subject', [
            'class' => $class,
            'student' => $student,
            'subsTaken' => $subsTaken,
        ]);
    }

    private function convertTeacherNameFormat($teachers) {
        if ($teachers instanceof Collection) {
            return $teachers->map(function ($teacher) {
                $title = strtolower($teacher->gender) === 'men' ? 'Mr.' : 'Mrs.';
                $teacher->name = $title . ' ' . Str::title($teacher->name);
                return $teacher;
            });
        } else {
            $title = strtolower($teachers->gender) === 'men' ? 'Mr.' : 'Mrs.';
            return $title . ' ' . Str::title($teachers->name);
        }
    }

    public function createNewSubject(AddSubjectRequest $request): RedirectResponse {
        $request->validated();

        $subject = Subject::create([
            'name' => $request->name,
            'form_id' => $request->form,
            'description' => $request->description,
        ]);

        $subject->save();

        if ($request->teachers != null) {
            $subjectTeacher = [];
    
            foreach ($request->teachers as $teacherId) {
                $subjectTeacher[] = [
                    'user_id' => $teacherId,
                    'subject_id' => $subject->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            DB::table('subject__teachers')->insert($subjectTeacher);
        }

        return redirect()->route('all_subjects')->with('blue-message', 'Successfully Register New Subject');
    }

    public function updateSubjectInfo(UpdateSubjectInfoRequest $request, $id): RedirectResponse {
        $newInfo = $request->validated();
        
        $sub = Subject::findOrFail($id);

        $sub->update($newInfo);

        return redirect()->route('edit_subject', ['id' => $id ])->with('blue-message', 'Successfully Update Subject Info');
    }

    public function deleteSubject($id): RedirectResponse {
        $subject = Subject::findOrFail($id);

        $subject->delete();

        return redirect()->route('all_subjects')->with('red-message', 'Successfully Delete Subject');
    }

    public function addSubjectTeacher(Request $request, $id): RedirectResponse {
        $subjectTC = Subject_Teacher::create([
            'user_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subjectTC->save();

        return redirect()->route('edit_subject', ['id' => $id])->with('blue-message', 'Teacher Successfuly Added');
    }

    public function dropSubjectTeacher($id, $teacher_id): RedirectResponse {
        $subjectTC = Subject_Teacher::where('user_id', $teacher_id)->where('subject_id', $id)->first();
        $subjectTC->delete();

        return redirect()->route('edit_subject', ['id' => $id])->with('red-message', 'Teacher Has Been Removed');
    }

    public function addSubjectClass(Request $request, $id): RedirectResponse {
        $request->validate([
            'subject' => 'required|exists:subjects,id',
            'assigned_teacher' => 'required|exists:subject__teachers,id',
        ]);

        $class = Classroom::findOrFail($id);

        if (!$class) {
            return redirect()->back()->withErrors(['message' => 'Classroom Not Found.']);
        }

        $subjectClass = Subject_Taken::create([
            'student_id' => NULL,
            'classroom_id' => $class->id,
            'subject_id' => $request->subject,
            'subject_teacher_id' => $request->assigned_teacher,
        ]);

        $subjectClass->save();

        return redirect()->route('class_subject', ['id' => $id])->with('blue-message', 'Subject Successfuly Add To Class');
    }

    public function changeSubjectTeacher(Request $request): RedirectResponse {

        $request->validate([
            'subject' => 'required|exists:subjects,id',
            'new_teacher' => 'required|exists:users,id',
            'class' => 'required|exists:classrooms,id',
        ]);

        $subsClass = Subject_Taken::where('classroom_id', $request->class)->where('subject_id', $request->subject)->first();

        if (!$subsClass) {
            return redirect()->back()->withErrors(['message' => 'Subject not found for the selected class.']);
        }

        $subTeaches = Subject_Teacher::where('subject_id', $request->subject)->where('user_id', $request->new_teacher)->first();

        if (!$subTeaches) {
            return redirect()->back()->withErrors(['message' => 'Teacher not found for the selected subject.']);
        }

        $subsClass->update(['subject_teacher_id' => $subTeaches->id]);

        return redirect()->route('class_subject', ['id' => $request->class])->with('blue-message', 'Teacher Successfuly Change');
    }

    public function dropClassroomSubject($id, $class_id): RedirectResponse {
        $subClass = Subject_Taken::findOrFail($id);
        $subClass->delete();

        return redirect()->route('class_subject', ['id' => $class_id])->with('red-message', 'Subject Successfully Drop From Classroom');
    }

    public function addStudentElectiveSubject() {
        
    }
}