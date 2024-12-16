<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Classroom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load('subjecttaken', 'subjects');

        $subClassTeacher = $this->getTeachesSubjectClass($user);

        return view('manageAccount.profile.edit', [
            'user' => $user,
            'subClassTeacher' => $subClassTeacher,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse {
    $user = $request->user();

    $user->fill($request->except(['verification', 'photo']));

    if ($request->hasFile('verification')) {
        if ($user->verification && Storage::disk('public')->exists('asset/verification-files/' . $user->verification)) {
            Storage::disk('public')->delete('asset/verification-files/' . $user->verification);
        }

        $user->verification = $request->file('verification')->getClientOriginalName();
        $request->file('verification')->storeAs('asset/verification-files', $user->verification, 'public');
    }

    if ($request->hasFile('photo')) {
        if ($user->photo && Storage::disk('public')->exists('asset/profile-photos/' . $user->photo)) {
            Storage::disk('public')->delete('asset/profile-photos/' . $user->photo);
        }

        $user->photo = $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('asset/profile-photos', $user->photo, 'public');
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('blue-message', 'Successfully Updated Profile');
}

    
    private function getTeachesSubjectClass($user) {
        $subClassTeacher = [];

        foreach ($user->subjects as $subs) {
            $subjectTeach = $subs->name;
            $subjectForm = $subs->form->name;

            $takenSubjects = $user->subjecttaken->where('subject_id', $subs->id)->where('student_id', NULL);

            $classNames = [];

            foreach ($takenSubjects as $takenSubject) {
                $class = Classroom::find($takenSubject->classroom_id);
                
                if ($class) {
                    $classNames[] = [
                        'class_id' => $class->id,
                        'class_name' => $class->name,
                    ];
                } else {
                    $classNames[] = [
                        'class_id' => null,
                        'class_name' => 'No Class Teaches',
                    ];
                }
            }

            if (empty($classNames)) {
                $classNames[] = [
                    'class_id' => null,
                    'class_name' => 'No Class Teaches',
                ];
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
}
