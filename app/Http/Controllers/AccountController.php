<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    //
    public function viewAllTeacher(): View {
        $teachers = User::where('id', '!=', Auth::id())->paginate(10);

        foreach ($teachers as $teacher) {
            $teacher->name =  Str::title($teacher->name);
        }

        return view('manageAccount.all_teacher', [
            'teachers' => $teachers,
        ]);
    }

    // if more than 10 name it display all at second paginate
    public function searchTeacherName(Request $request): View|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'search_teacher' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $searchTerm = $request->input('search_teacher');
        $teachers = User::where('name', 'LIKE', '%' . $searchTerm . '%')->paginate(10);

        if ($teachers->isEmpty()) {
            return redirect()->route('all_teacher')->with('red-message', 'Teacher Not Found.');
        }
        
        return view('manageAccount.all_teacher', compact('teachers'));
    }


    public function viewTeacherDetails($id): View {
        $teacher = User::findOrFail($id);

        $teacher->name = Str::title($teacher->name);

        $ageOnIc = (substr($teacher->ic, 0, 2));
        
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;

        $age = $yearNow - ($century + $ageOnIc);

        $subClassTeacher = $this->getTeachesSubjectClass($teacher);

        return view('manageAccount.teacher_details', compact('teacher', 'age', 'subClassTeacher'));
    }

    public function destroyTeacher($id): RedirectResponse {        
        $user = User::findOrFail($id);

        if($user->classroom) {
            $classes = Classroom::where('classteacher_id', $id)->get();
            
            foreach ($classes as $class) {
                $class->update(['classteacher_id' => NULL]);
            }
        }

        $user->delete();

        return redirect()->route('all_teacher')->with('red-message', 'Successfully Delete Teacher');
    }

    private function getTeachesSubjectClass($user) {
        $subClassTeacher = [];

        foreach ($user->subjects as $subs) {
            $subjectTeach = $subs->name;
            $subjectForm = $subs->form->name;

            $takenSubjects = $user->subjecttaken->where('subject_id', $subs->id);

            $classNames = [];

            foreach ($takenSubjects as $takenSubject) {
                $class = Classroom::find($takenSubject->classroom_id);
                $classNames[] = $class ? $class->name : 'No Class Teaches';
            }

            if (empty($classNames)) {
                $classNames[] = 'No Class Teaches';
            }

            $subClassTeacher[] = [
                'subjectTeach' => $subjectTeach,
                'subjectForm' => $subjectForm,
                'classNames' => $classNames,
            ];
        }

        return $subClassTeacher;
    }
}
