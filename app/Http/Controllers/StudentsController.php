<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function viewAllStudent(): View {
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

    public function viewStudentDetails($id): View {
        $std = Student::findOrFail($id);

        $ageOnIc = (substr($std->ic, 0, 2));
        
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;

        $age = $yearNow - ($century + $ageOnIc);

        $std->dob = Carbon::parse($std->dob)->format('j F Y');
        $std->join_school_date = Carbon::parse($std->join_school_date)->format('j F Y');

        return view('manageClassroom.manageStudents.view_student', compact('std', 'age'));
    }

    public function addNewStudent(AddStudentRequest $request): RedirectResponse {
        $request->validated();

        return redirect()->route('all_student')->with('blue-message', 'Student Successfully Registered');
    }
}
