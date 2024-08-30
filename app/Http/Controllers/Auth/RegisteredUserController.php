<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTeacherRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function viewAddTeacher(): View {
        $roles = Role::all();
        $userRoles = [];

        return view('manageAccount.add_teacher', compact('roles', 'userRoles'));
    }

    public function store(RegisterTeacherRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'teacher_id' => $request->teacher_id,
            'ic' => $request->ic,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'verification' => 'testuser.pdf'
        ]);

        $user->save();

        $userRoles = $request->input('roles');

        $roleIds = Role::whereIn('name', $userRoles)->pluck('id');

        $user->roles()->sync($roleIds);

        return redirect(route('all_teacher'));
    }
}
