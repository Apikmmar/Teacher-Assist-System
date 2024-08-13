<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
