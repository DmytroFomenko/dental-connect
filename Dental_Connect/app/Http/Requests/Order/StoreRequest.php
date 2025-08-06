<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'patient_name' => 'required|string|max:50',
            'phone' => ['required', 'string', 'regex:/^\d{10}$/'],
            'dentist_id' => 'required|integer|exists:dentists,id',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_name.required' => 'Please enter your name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'The phone number format is invalid.',
            'dentist_id.required' => 'Please select a dentist.',
            'dentist_id.exists' => 'The selected dentist does not exist.',
        ];
    }

}
