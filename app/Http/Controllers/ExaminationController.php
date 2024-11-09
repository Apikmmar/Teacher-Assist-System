<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddExaminationRequest;
use App\Models\Examination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ExaminationController extends Controller
{
    //
    public function viewAllExamination(): View {
        $examinations = Examination::orderBy('start_date', 'desc')->orderBy('status')->paginate(10);
        $duration = $this->convertExamDate($examinations);


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

        $examinationType = $request->type === 'Other' ? $request->otherExam : $request->type;

        $exam = Examination::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'type' => $examinationType,
            'release_date' => $request->release_date,
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
    
    public function searchExamination(Request $request): View {
        $validator = Validator::make($request->all(), [
            'search_examination' => 'required | string | max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $searchTerm = $request->input('search_examination');

        $examinations = Examination::where('name', 'LIKE', '%' . $searchTerm . '%')->orderBy('start_date', 'desc')->orderBy('status')->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function filterExamination(Request $request): View {
        $query = Examination::query();

        if ($request->filled('sort_name')) {
            $order = $request->sort_name === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('name', $order);
        }

        if ($request->filled('sort_duration')) {
            $order = $request->sort_duration === 'ASC' ? 'asc' : 'desc';
            $query->selectRaw('*, DATEDIFF(end_date, start_date) + 1 as duration')->orderBy('duration', $order);
        }

        if ($request->filled('sort_release')) {
            $order = $request->sort_release === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('release_date', $order);
        }

        if ($request->filled('status_release')) {
            $query->where('status', 'Release');
        }

        if ($request->filled('status_pending')) {
            $query->where('status', 'Pending');
        }

        $examinations = $query->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    private function convertExamDate($examinations) {
        $duration = [];

        foreach ($examinations as $exam) {
            $startDate = Carbon::parse($exam->start_date);
            $endDate = Carbon::parse($exam->end_date);
            $releaseDate = Carbon::parse($exam->release_date);
            
            $duration[] = $startDate->diffInDays($endDate) + 1;
            
            $exam->start_date = $startDate->format('j F Y');
            $exam->end_date = $endDate->format('j F Y');
            $exam->release_date = $releaseDate->format('j F Y');
        }

        return $duration;
    }
}