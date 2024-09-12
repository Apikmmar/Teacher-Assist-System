<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterClassroomRequest;
use App\Models\Classroom;
use App\Models\Form;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ClassroomController extends Controller
{
    public function viewAllClassroom(Request $request): View {

        if($request->class_form != '') {
            $classrooms = Classroom::where('form_id', $request->class_form)->orderBy('name')->paginate(10);
        } else {
            $classrooms = Classroom::orderBy('name')->paginate(10);
        }
    
        foreach ($classrooms as $classroom) {
            $teacherName = Str::title($classroom->classteacher->name);

            if (strtolower($classroom->classteacher->gender) == 'men') {
                $classroom->teacher_title = 'Mr. ' . $teacherName;
            } else {
                $classroom->teacher_title = 'Mrs. ' . $teacherName;
            }
        }
    
        return view('manageClassroom.manageClass.all_classroom', [
            'classrooms' => $classrooms,
            'forms' => Form::all(),
        ]);
    }

    public function viewAddClassroom(): View {
        $stdSelected = [];
        $forms = Form::all();
        $students = Student::where('classroom_id', NULL)->where('status', 'Active')->get();

        $yearNow = date('Y');
    
        foreach ($students as $student) {
            $ageOnIc = substr($student->ic, 0, 2);
            $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;
            $student->age = $yearNow - ($century + $ageOnIc);
        }

        $availableTeachers = User::whereDoesntHave('classroom', function($query) {
            $query->whereNotNull('classteacher_id');
        })->get();

        foreach ($availableTeachers as $teacher) {
            $teacher->name = (strtolower($teacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ') . Str::title($teacher->name);
        }

        return view('manageClassroom.manageClass.add_classroom', [
            'stdSelected' => $stdSelected,
            'forms' => $forms,
            'students' => $students,
            'availableTeachers' => $availableTeachers
        ]);
    }

    public function viewClassroomDetails($id): View {;
        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.view_classroom', $data);
    }

    public function viewClassTeacherClassroom(): View {
        $user = Auth::user();
        $id = $user->classroom->id;

        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.view_classroom', $data);
    }

    public function viewEditClassroom($id): View {
        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.edit_classroom', $data);
    }

    private function getClassroomData($id) {
        $classroom = Classroom::findOrFail($id);
        $students = Student::where('classroom_id', $classroom->id)->paginate(10);

        $teacherName = (strtolower($classroom->classteacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ') . Str::title($classroom->classteacher->name);

        return [
            'classroom' => $classroom,
            'students' => $students,
            'teacherName' => $teacherName,
        ];
    }

    public function registerNewClassroom(RegisterClassroomRequest $request) {
        $request->validated();

        $students = $request->input('students');

        $classroom = Classroom::create([
            'form_id' => $request->form,
            'name' => $request->name,
            'classteacher_id' => $request->class_teacher,
            'num_student' => count($students),
        ]);

        $classroom->save();

        foreach ($students as $std) {
            $student = Student::findOrFail($std);
            $student->classroom_id = $classroom->id;
            $student->save();
        }

        return redirect()->route('all_classroom')->with('blue-message', 'Classroom Successfully Registered');
    }

    // if more than 10 name it display all at second paginate
    public function searchClassroomName(Request $request): View|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'search_classroom' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $searchTerm = $request->input('search_classroom');
        $classrooms =Classroom::where('name', 'LIKE', '%' . $searchTerm . '%')->paginate(10);

        if ($classrooms->isEmpty()) {
            return redirect()->route('all_classroom')->with('red-message', 'Class Not Found.');
        }
        
        return view('manageClassroom.manageClass.all_classroom', compact('classrooms'));
    }


    public function deleteClassroom($id) {
        $class = Classroom::findOrFail($id);

        $students = $class->students;

        foreach ($students as $std) {
            $std->classroom_id = NULL;
            $std->save();
        }

        $class->delete();

        return redirect()->route('all_classroom')->with('red-message', 'Classroom Successfully Registered');
    }

    
    public function removeStudentClass($id): RedirectResponse {
        $std = Student::findOrFail($id);

        $class1 = $std->classroom_id;
        $name = $std->name;

        
        $std->classroom_id = null;
        $std->save();

        if ($class1) {
            $classroom = Classroom::findOrFail($class1);
            $classroom->num_student = $classroom->students()->count();
            $classroom->save();
        }

        return redirect()->route('edit_classroom', ['id' => $class1])->with('red-message', 'Student '. $name . ' Is Removed From Class ' . $classroom->name);
    }
}
