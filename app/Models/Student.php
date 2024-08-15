<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'student_id',
        'name',
        'ic',
        'gender',
        'dob',
        'join_school_date',
        'status',
    ];

    public function classroom(): BelongsTo {
        return $this->belongsTo(Classroom::class);
    }

    public function transition(): HasOne {
        return $this->hasOne(Transition::class);
    }

    public function studentgrades(): HasMany {
        return $this->hasMany(Student_Grade::class);
    }

    public function studentexamreports(): HasMany {
        return $this->hasMany(Student_Examination_Report::class);
    }

    public function subjects():  BelongsToMany {
        return $this->belongsToMany(Subject::class, 'subject_taken', 'student_id', 'subject_id');
    }
}
