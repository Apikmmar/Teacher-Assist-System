<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClassroomRequest extends FormRequest
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
            'form' => ['required', 'integer', 'exists:forms,id'],
            'name' => ['required', 'string', 'max:50'],
            'class_teacher' => ['required', 'integer', 'exists:users,id'],
            'students' => ['required', 'array', 'min:1'],
            'students.*' => ['exists:students,id'],
        ];
    }
}
