<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'name',
        'description',
    ];

    public function teachers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'subject__teachers', 'subject_id', 'user_id');
    }

    public function classrooms(): BelongsToMany {
        return $this->belongsToMany(Classroom::class, 'subject_taken', 'subject_id', 'classroom_id');
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }

    public function studentgrade(): HasMany {
        return $this->hasMany(Student_Grade::class);
    }
}
