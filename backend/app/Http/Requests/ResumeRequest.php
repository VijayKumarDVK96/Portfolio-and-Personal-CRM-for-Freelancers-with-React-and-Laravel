<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
            'type' => 'required|in:education,experience',
            'title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'from_year' => 'required|date_format:Y',
            'to_year' => 'required|date_format:Y|after_or_equal:from_year',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Type is required',
            'type.in' => 'Type must be either education or experience',
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title may not be greater than 255 characters',
            'institution.required' => 'Institution is required',
            'institution.string' => 'Institution must be a string',
            'institution.max' => 'Institution may not be greater than 255 characters',
            'from_year.required' => 'From year is required',
            'from_year.date_format' => 'From year must be in the format YYYY',
            'to_year.required' => 'To year is required',
            'to_year.date_format' => 'To year must be in the format YYYY',
            'to_year.after_or_equal' => 'To year must be a year after or equal to From year',
            'location.required' => 'Location is required',
            'location.string' => 'Location must be a string',
            'location.max' => 'Location may not be greater than 255 characters',
            'description.string' => 'Description must be a string',
            'icon.string' => 'Icon must be a string',
        ];
    }
}
