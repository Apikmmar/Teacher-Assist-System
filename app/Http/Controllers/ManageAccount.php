<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ManageAccount extends Controller
{
    //
    public function viewAllTeacher(): View {
        $teachers = User::all();

        return view('manageAccount.all_teacher', compact('teachers'));
    }

    public function viewAddTeacher(): View {
        return view('manageAccount.add_teacher');
    }
}
