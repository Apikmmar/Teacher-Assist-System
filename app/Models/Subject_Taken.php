<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject_Taken extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'classroom_id',
        'subject_id',
        'subject_teacher_id',
    ];

    public function classroom(): BelongsTo {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function subject(): BelongsTo {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function subjectTeacher(): BelongsTo {
        return $this->belongsTo(Subject_Teacher::class, 'subject_teacher_id');
    }
}
