<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_Taken extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'classroom_id',
        'subject_id',
        'subject_teacher_id',
    ]; 
}
