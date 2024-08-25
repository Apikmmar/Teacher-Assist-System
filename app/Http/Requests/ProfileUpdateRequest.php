<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:Men,Women', 'max:10'],
            'contact' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'verification' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
        ];
    }
}