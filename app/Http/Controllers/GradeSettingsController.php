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

}
