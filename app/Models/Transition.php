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
        'lastclass_id',
        'transition_date',
        'change_school_reason',
        'new_school_name',
        'reason_drop',
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }
}
