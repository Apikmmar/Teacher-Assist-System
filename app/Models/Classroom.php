<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'classteacher_id',
        'name',
        'num_student',
    ];

    public function classteacher(): BelongsTo {
        return $this->belongsTo(User::class, 'classteacher_id');
    }

    public function subjects():  BelongsToMany {
        return $this->belongsToMany(Subject::class, 'subject_taken', 'classroom_id', 'subject_id');
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function students(): HasMany {
        return $this->hasMany(Student::class);
    }
}
