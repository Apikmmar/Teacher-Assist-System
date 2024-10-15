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
            'change_reason' => ['required', 'string', 'max:100'],
            'new_school' => ['required', 'string', 'max:100'],
            'drop_reason' => ['required', 'string', 'max:100'],
            'date_transition' => ['required', 'date'],
        ];
    }
}
