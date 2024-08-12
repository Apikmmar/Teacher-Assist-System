<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'subject_id',
        'student_id',
        'grade',
        'marks',
        'grade_value',
        'is_passed',
        'feedback',
    ];
}
