<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transition extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'change_school_date',
        'reason_change',
        'new_school_name',
        'drop_school_date',
        'reason_drop',
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }
}
