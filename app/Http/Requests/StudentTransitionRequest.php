<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentTransitionRequest extends FormRequest
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
            'change_school_reason' => ['nullable', 'string', 'max:100'],
            'new_school_name' => ['nullable', 'string', 'max:100'],
            'reason_drop' => ['nullable', 'string', 'max:100'],
            'transition_date' => ['nullable', 'date'],
        ];
    }
}
