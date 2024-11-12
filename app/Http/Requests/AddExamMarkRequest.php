<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddExamMarkRequest extends FormRequest
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
            //
            'exam_id' => ['required', 'exists:examinations,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'student_marks' => ['required', 'array', 'min:1'],
            'student_marks.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'student_grades' => ['required', 'array', 'min:1'],
            'student_grades.*' => ['required', 'string'],
            'grade_values' => ['required', 'array', 'min:1'],
            'student_feedbacks' => ['nullable', 'array', 'min:1'],
            'students_id' => ['required', 'array', 'min:1'],
            'students_id.*' => ['exists:students,id'],
        ];
    }
}
