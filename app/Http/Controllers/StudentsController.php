<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Http\Requests\StudentTransitionRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject_Taken;
use App\Models\Transition;
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

        $age = $this->calculateAge($std->ic);

        if($std->classroom_id) {
            $class = Classroom::findOrFail($std->classroom_id);
            $std->name = Str::title($std->name);
    
            $std->dob = Carbon::parse($std->dob)->format('j F Y');
            $std->join_school_date = Carbon::parse($std->join_school_date)->format('j F Y');
    
            $subsTaken = $this->getStudentSubjects($class->id, $std->id);
        } else {
            $class = null;
            $subsTaken = null;
        }

        return view('manageClassroom.manageStudents.view_student', [
            'std' => $std,
            'class' => $class,
            'age' => $age,
            'subsTaken' => $subsTaken,
        ]);
    }

    public function viewEditStudent($id) {
        $std = Student::findOrFail($id);
        $classes = Classroom::all();
        
        if ($std->classroom_id) {
            $std_class = Classroom::findOrFail($std->classroom_id);
        } else {
            $std_class = NULL;
        }

        return view('manageClassroom.manageStudents.edit_student', [
            'std' => $std,
            'std_class' => $std_class,
            'classes' => $classes,
            'age' => $this->calculateAge($std->ic),
        ]);
    }

    private function calculateAge($ic) {
        $ageOnIc = (substr($ic, 0, 2));
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;
        $age = $yearNow - ($century + $ageOnIc);

        return $age;
    }

    private function getStudentSubjects($classid, $stdid) {
        $allSubjects = Subject_Taken::where('classroom_id', $classid)->orWhere('student_id', $stdid)->get();

        $subsTaken = [];

        foreach ($allSubjects as $subject) {
            if ($subject->subject != NULL) {
                $subsTaken[] = Str::title($subject->subject->name);
            } else {
                $subsTaken[] = 'N/A';
            }
        }
        $subsTaken = collect($subsTaken);
        return $subsTaken;
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

    public function filterStudent(Request $request) {
        $query = Student::query();
    
        // Apply sorting if provided
        if ($request->filled('sort_name')) {
            $order = $request->sort_name === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('name', $order);
        }
    
        if ($request->filled('sort_ic')) {
            $order = $request->sort_ic === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('ic', $order);
        }
    
        // Apply status filtering
        if ($request->filled('status_active')) {
            $query->where('status', 'active');
        }
        
        if ($request->filled('status_inactive')) {
            $query->where('status', 'inactive');
        }
    
        // Apply gender filtering
        if ($request->filled('gender_men')) {
            $query->where('gender', 'Men');
        }
    
        if ($request->filled('gender_women')) {
            $query->where('gender', 'Women');
        }
    
        // Determine the pagination limit
        $paginationLimit = $request->hasAny(['sort_name', 'sort_ic', 'status_active', 'status_inactive', 'gender_men', 'gender_women']) ? 10 : 100;
    
        // Retrieve paginated students
        $students = $query->paginate($paginationLimit);
    
        return view('manageClassroom.manageStudents.all_student', [
            'students' => $students
        ]);
    }
    

    public function updateStudentInfo(UpdateStudentRequest $request,$id): RedirectResponse {
        $data = $request->validated();

        $std = Student::findOrFail($id);

        $std->update($data);
        
        if ($data['status'] === 'Inactive') {
            $std->update(['classroom_id' => NULL]);
        }

        return redirect()->route('edit_student', ['id' => $id])->with('blue-message', 'Successfully Update Student Data');
    }

    public function deleteStudent($id): RedirectResponse {
        $std = Student::findOrFail($id);
        $std->delete();

        return redirect()->route('all_student')->with('red-message', 'Student Deleted');
    }

    public function addStudentTranstion(StudentTransitionRequest $request, $id): RedirectResponse {
        $request->validate([
            'change_school_reason' => ['required', 'string', 'max:100'],
            'new_school_name' => ['required', 'string', 'max:100'],
            'reason_drop' => ['required', 'string', 'max:100'],
            'transition_date' => ['required', 'date'],
        ]);

        $std = Student::findOrFail($id);
        $class = Classroom::findOrFail($std->classroom_id);
        
        Transition::create([
            'change_school_reason' => $request->change_school_reason,
            'student_id' => $std->id,
            'lastclass_id' => $class->id,
            'new_school_name' => $request->new_school_name,
            'reason_drop' => $request->reason_drop,
            'transition_date' => $request->transition_date,
        ]);
        
        // $transition->save();

        $std->update(['classroom_id' => NULL, 'status' => 'Inactive']);

        return redirect()->route('view_student', ['id' => $id])->with('red-message', 'Student Drop From School');
    }
}
