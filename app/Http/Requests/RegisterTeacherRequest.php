<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ic' => ['required', 'string', 'size:12'],
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:Men,Women', 'max:10'],
            'contact' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,name'],

        ];
    }
}
