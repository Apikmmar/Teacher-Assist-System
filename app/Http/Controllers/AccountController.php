<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    //
    public function viewAllTeacher(): View {
        $teachers = User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->orderBy('ic', 'asc')->paginate(10);

        foreach ($teachers as $teacher) {
            $teacher->name =  Str::title($teacher->name);
        }

        return view('manageAccount.all_teacher', [
            'teachers' => $teachers,
        ]);
    }

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

        usort($subClassTeacher, function ($a, $b) {
            return strcmp($a['subjectForm'], $b['subjectForm']);
        });

        return $subClassTeacher;
    }

    public function importUser(Request $request) {
        $request->validate([
            'import_csv' => 'required|mimes:csv',
        ]);

        $file = $request->file('import_csv');
        $handle = fopen($file->path(), 'r');

        fgetcsv($handle);

        $chunksize = 25;

        while(!feof($handle)) {
            $chunkdata = [];

            for ($i=0; $i < $chunksize; $i++) { 
                $data = fgetcsv($handle);

                if ($data === false) {
                    break;
                }
                $chunkdata[] = $data;
            }

            foreach($chunkdata as $column) {
                $teacher_id = $column[0];
                $name = $column[1];
                $ic = $column[2];
                $gender = $column[3];
                $contact = $column[4];
                $email = $column[5];

                $teacher = new User();
                $teacher->teacher_id = $teacher_id;
                $teacher->name = $name;
                $teacher->ic = $ic;
                $teacher->gender = $gender;
                $teacher->contact = $contact;
                $teacher->email = $email;
                $teacher->password = Hash::make($ic);
                $teacher->verification = NULL;
                $teacher->photo = NULL;

                $teacher->save();
            }
        }

        return redirect()->route('all_teacher')->with('blue-message', 'Successfully Import New Teacher Data!');
    }
}
