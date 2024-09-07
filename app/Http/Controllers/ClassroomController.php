<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Form;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ClassroomController extends Controller
{
    public function viewAllClassroom(): View {
        $classrooms = Classroom::orderBy('name')->paginate(10);
    
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
        ]);
    }

    public function viewClassroomDetails($id): View {
        $classroom = Classroom::findOrFail($id);
        $students = Student::where('classroom_id', $classroom->id)->paginate(10);

        $teacherName = (strtolower($classroom->classteacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ') . Str::title($classroom->classteacher->name);

        return view('manageClassroom.manageClass.view_classroom', [
            'classroom' => $classroom,
            'students' =>  $students,
            'teacherName' => $teacherName,
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

    public function registerNewClassroom(Request $request) {

        dd($request);

        // return redirect()->route('all_classroom')->with('blue-message', 'Classroom Successfully Registered');
    }
}
