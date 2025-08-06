<?php

namespace App\Http\Requests\Appointment;

use App\Rules\BeginAfterNow;
use App\Rules\NoScheduleOverlap;
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
            'patient_name' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'date' => ['required', 'date'],
            'begin_time' => [
                'required',
                'date_format:H:i',
                new BeginAfterNow($this->input('date'), $this->input('begin_time')),
                ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:begin_time',
                new NoScheduleOverlap(
                    $this->input('date'),
                    $this->input('begin_time'),
                    $this->input('end_time'),
                    $this->user()->dentist->id
                ),
            ],
            'order_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_name.required' => 'Patient name is required.',
            'phone_number.required' => 'Phone number is required.',
            'date.required' => 'Please select a date.',
            'date.date' => 'Invalid date format.',
            'begin_time.required' => 'Please enter a start time.',
            'begin_time.date_format' => 'Start time must be in HH:MM format.',
            'end_time.required' => 'Please enter an end time.',
            'end_time.date_format' => 'End time must be in HH:MM format.',
            'end_time.after' => 'End time must be after the start time.',
        ];
    }

}
