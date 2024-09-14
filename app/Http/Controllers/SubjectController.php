<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View as View;

class SubjectController extends Controller
{
    public function viewAllSubject(Request $request): View {
        if($request->subject_form != '') {
            $subjects = Subject::where('form_id', $request->class_form)->orderBy('name')->paginate(10);
        } else {
            $subjects = Subject::orderBy('name')->paginate(10);
        }

        return view('manageSubject.all_subjects', [
            'subjects' => $subjects,
            'forms' => Form::all(),
        ]);
    }
}
