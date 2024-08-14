<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'name',
        'description',
    ];

    public function teachers(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function classrooms(): BelongsToMany {
        return $this->belongsToMany(Classroom::class);
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }
}
