<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Models\Classroom;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;

class StudentsController extends Controller
{

    public function viewAllStudent(): View {
        $students = Student::paginate(10);

        foreach ($students as $student) {
            $student->name =  Str::title($student->name);
        }

        return view('manageClassroom.manageStudents.all_student', [
            'students' => $students
        ]);
    }

    public function viewAddStudent() {
        return view('manageClassroom.manageStudents.add_student', [
            'classes' => Classroom::all()
        ]);
    }

    public function viewStudentDetails($id): View {
        $std = Student::findOrFail($id);
        $classes = Classroom::all();

        $std->name = Str::title($std->name);

        $ageOnIc = (substr($std->ic, 0, 2));
        
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;

        $age = $yearNow - ($century + $ageOnIc);

        $std->dob = Carbon::parse($std->dob)->format('j F Y');
        $std->join_school_date = Carbon::parse($std->join_school_date)->format('j F Y');

        return view('manageClassroom.manageStudents.view_student', compact('std', 'age', 'classes'));
    }

    public function addNewStudent(AddStudentRequest $request): RedirectResponse {
        $request->validated();

        $std = Student::create([
            'classroom_id' => $request->classroom,
            'ic' => $request->ic,
            'student_id' => 'ST'.str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'join_school_date' => $request->jsd,
            'status' => $request->status,
        ]);

        $std->save();

        return redirect()->route('all_student')->with('blue-message', 'Student Successfully Registered');
    }

    public function registerStudentClass(Request $request, $id): RedirectResponse {
        $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
        ]);

        $class = Classroom::findOrFail($request->classroom_id);
        $std = Student::findOrFail($id);

        $std->update(['classroom_id' => $class->id]);

        return redirect()->route('view_student', ['id' => $id])->with('blue-message', 'Successfully Add Student to ' . $class->name . '.');
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

    public function deleteStudent($id): RedirectResponse {
        $std = Student::findOrFail($id);
        $std->delete();

        return redirect()->route('all_student')->with('red-message', 'Student Deleted');
    }
}
