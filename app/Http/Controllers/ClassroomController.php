<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Form;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ClassroomController extends Controller
{
    public function viewAllClassroom(): View {
        $classrooms = Classroom::paginate(10);
    
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
        $forms = Form::all();

        return view('manageClassroom.manageClass.add_classroom', [
            'forms' => $forms
        ]);
    }
}
