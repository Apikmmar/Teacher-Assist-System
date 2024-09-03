<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function viewAllStudent() : View {
        return view('manageClassroom.manageStudents.all_student', [
            'students' => Student::paginate(10)
        ]);
    }

    // if more than 10 name it display all at second paginate
    public function searchStudentName(Request $request): View|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'search_student' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $searchTerm = $request->input('search_student');
        $students = Student::where('name', 'LIKE', '%' . $searchTerm . '%')->paginate(10);

        if ($students->isEmpty()) {
            return redirect()->route('all_student')->with('red-message', 'Student Not Found.');
        }
        
        return view('manageClassroom.manageStudents.all_student', compact('students'));
    }

    public function viewAddStudent() {
        return view('manageClassroom.manageStudents.add_student');
    }

    public function viewStudentDetails($id) {
        $std = Student::findOrFail($id);

        return view('manageClassroom.manageStudents.add_student', compact('std'));
    }
}
