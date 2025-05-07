<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examination_Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'grade',
        'mark_min',
        'mark_max',
        'grade_value',
        'is_passed'
    ];

    public function form(): BelongsTo {
        return $this->belongsTo(Examination_Grade::class);
    }
}
