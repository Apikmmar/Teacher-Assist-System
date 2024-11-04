<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddExaminationRequest;
use App\Models\Examination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ExaminationController extends Controller
{
    //
    public function viewAllExamination(): View {
        $examinations = Examination::orderBy('start_date', 'desc')->orderBy('status')->paginate(10);
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
            'exam' => Examination::findOrFail($id),
        ]);
    }

    public function addNewExamination(AddExaminationRequest $request): RedirectResponse {
        $request->validated();

        $exam = Examination::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'type' => $request->type,
        ]);

        return redirect()->route('view_examination', ['id' => $exam->id])->with('blue-message', 'Successfully Registered New Examination');
    }

    public function updateExaminationDetails(Request $request, $id): RedirectResponse {
        $newData = $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'type' => ['nullable', 'string', 'max:200'],
        ]);

        $exam = Examination::findOrFail($id);

        $exam->update($newData);

        return redirect()->route('view_examination', ['id' => $id])->with('blue-message', 'Successfully Update Examination Data');
    }

    public function deleteExamination($id): RedirectResponse {
        $exam = Examination::findOrFail($id);

        $exam->delete();

        return redirect()->route('all_examination')->with('red-message', 'Examination Data Is Deleted');
    }

    public function releaseExamination($id): RedirectResponse {
        $exam = Examination::findOrFail($id);

        $exam->update(['status' => 'Release']);

        return redirect()->route('view_examination', ['id' => $id])->with('blue-message', 'Examination Data Is Released');
    }
}
