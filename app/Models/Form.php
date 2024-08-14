<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_class',
    ];

    public function classrooms(): HasMany {
        return $this->hasMany(Classroom::class);
    }

    public function subject(): HasMany {
        return $this->hasMany(Subject::class);
    }
}
