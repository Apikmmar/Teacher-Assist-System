<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('manageAccount.profile.edit', [
            'user' => $request->user(),
        ]);
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
