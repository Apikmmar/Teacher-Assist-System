<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_Grade extends Model
{
    use HasFactory;
<<<<<<< HEAD

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
=======
>>>>>>> a64914fbbe6cede6cfb619cffb79dbd7b8287d2a
}
