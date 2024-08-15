<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function subject(): BelongsTo {
        return $this->belongsTo(Subject::class);
    }

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }

    public function examination():BelongsTo {
        return $this->belongsTo(Examination::class);
    }
}
