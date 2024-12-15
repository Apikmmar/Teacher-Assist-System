<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'name',
        'ic',
        'gender',
        'contact',
        'email',
        'password',
        'verification',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'role__users', 'user_id', 'role_id');
    }

    public function hasRole($roleName) {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasAnyRole(array $roles) {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function classroom(): HasOne {
        return $this->hasOne(Classroom::class, 'classteacher_id');
    }

    public function subjects(): BelongsToMany {
        return $this->belongsToMany(Subject::class, 'subject__teachers', 'user_id', 'subject_id');
    }

    public function subjecttaken(): HasManyThrough {
        return $this->hasManyThrough(Subject_Taken::class, Subject_Teacher::class, 'user_id', 'subject_teacher_id', 'id', 'id');
    }

    public function examReports(): HasMany {
        return $this->hasMany(Student_Examination_Report::class, 'student_id');
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class);
    }
}
