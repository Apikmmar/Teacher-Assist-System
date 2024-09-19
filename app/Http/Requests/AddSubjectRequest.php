<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSubjectRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'form' => ['required', 'integer', 'exists:forms,id'],
            'description' => ['required', 'string', 'max:100'],
            'teachers' => ['nullable', 'array', 'min:1'],
            'teachers.*' => ['exists:users,id'],
        ];
    }
}
