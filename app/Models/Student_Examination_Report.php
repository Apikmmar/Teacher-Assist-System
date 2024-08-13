<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_Examination_Report extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $fillable = [
        'examination_id',
        'student_id',
        'total_mark',
        'average_mark',
        'pointer',
        'is_passed',
        'class_rank',
        'form_rank',
        'feedback',
    ];
=======
>>>>>>> a64914fbbe6cede6cfb619cffb79dbd7b8287d2a
}
