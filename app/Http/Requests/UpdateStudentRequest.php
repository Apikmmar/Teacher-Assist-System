<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'ic' => ['string', 'size:12'],
            'name' => ['string', 'max:100'],
            'gender' => ['string', 'in:Men,Women', 'max:10'],
            'dob' => ['date'],
            'jsd' => ['date'],
            'status' => ['string', 'in:Active,Inactive', 'max:20'],
            'classroom_id' => ['nullable']
        ];
    }
}
