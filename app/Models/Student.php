<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
