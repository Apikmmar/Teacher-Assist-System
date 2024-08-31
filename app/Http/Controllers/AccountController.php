<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    public function viewAllTeacher(): View {
        $teachers = User::where('id', '!=', Auth::id())->paginate(10);

        return view('manageAccount.all_teacher', compact('teachers'));
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

        $ageOnIc = (substr($teacher->ic, 0, 2));
        
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;

        $age = $yearNow - ($century + $ageOnIc);

        return view('manageAccount.teacher_details', compact('teacher', 'age'));
    }

    public function destroyTeacher($id): RedirectResponse {        
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('all_teacher')->with('red-message', 'Successfully Delete Teacher');
    }
}
