<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View as View;

class SubjectController extends Controller
{
    public function viewAllSubject(): View {

        return view('manageSubject.all_subjects', [
            'subjects' => Subject::paginate(10),
        ]);
    }
}
