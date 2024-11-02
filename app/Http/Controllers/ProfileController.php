<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Classroom;
use App\Models\Subject_Taken;
use App\Models\Subject_Teacher;
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

        return $subClassTeacher;
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->fill($request->except(['verification', 'photo']));

        // FILE AND IMAGE NOT DELETED
        if ($request->hasFile('verification')) {
            $user->verification = $request->file('verification')->getClientOriginalName();
            $request->file('verification')->storeAs('asset/verification-files', $user->verification, 'public');
        }

        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('asset/profile-photos', $user->photo, 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('blue-message', 'Successfully Update Profile');
    }
}
