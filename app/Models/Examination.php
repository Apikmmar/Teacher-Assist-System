<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'type',
        'release_date'
    ];

    public function studentgrades():HasMany {
        return $this->hasMany(Student_Grade::class);
    }

    public function studentexamreports():HasMany {
        return $this->hasMany(Student_Examination_Report::class);
    }
}
