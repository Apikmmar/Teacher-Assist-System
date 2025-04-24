<?php

namespace App\Http\Controllers;

use App\Models\Examination_Grade;
use App\Models\Form;
use Illuminate\Http\Request;

class GradeSettingsController extends Controller
{
    //
    public function viewAllGrade() {

        $forms = Form::all();

        return view('manageSubject.customizeGrade.all_grade',[
            'forms' => $forms,
        ]);
    }

    public function createNewGrade(Request $request) {

        $validatedRequest = $request->validate([
            'form_id' => ['required', 'exists:forms,id'],
            'grade' => ['required', 'string', 'max:1'],
            'mark_min' => ['required', 'numeric', 'min:0', 'max:100'],
            'mark_max' => ['required', 'numeric', 'min:0', 'max:100', 'gt:mark_min'],
            'grade_value' => ['required', 'numeric'],
        ]);

        $grade = Examination_Grade::create([
            'form_id' => $validatedRequest['form_id'],
            'grade' => strtoupper($validatedRequest['grade']),
            'mark_min' => $validatedRequest['mark_min'],
            'mark_max' => $validatedRequest['mark_max'],
            'grade_value' => $validatedRequest['grade_value'],
        ]);

        $grade->save();

        return redirect()->route('view.gradesettings')->with('blue-message', 'Student Successfully Registered');
    }
}
