<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ExaminationController extends Controller
{
    //
    public function viewAllExamination(): View {
        $examinations = Examination::orderBy('start_date')->orderBy('status')->paginate(10);
        $duration = [];

        foreach ($examinations as $exam) {
            $startDate = Carbon::parse($exam->start_date);
            $endDate = Carbon::parse($exam->end_date);
            
            $duration[] = $startDate->diffInDays($endDate) + 1;
            
            $exam->start_date = $startDate->format('j F Y');
            $exam->end_date = $endDate->format('j F Y');
        }

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function viewAddExamination(): View {
        return view('manageExamGrade.add_examination');
    }

    public function viewExaminationDetails($id): View {
        
        return view('manageExamGrade.examination_details', [
            'examination' => Examination::findOrFail($id),
        ]);
    }
}
