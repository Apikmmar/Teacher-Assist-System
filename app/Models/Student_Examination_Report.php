<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student_Examination_Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'student_id',
        'total_mark',
        'average_mark',
        'pointer',
        'is_passed',
        'feedback',
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function examination():BelongsTo {
        return $this->belongsTo(Examination::class, 'examination_id');
    }
}
