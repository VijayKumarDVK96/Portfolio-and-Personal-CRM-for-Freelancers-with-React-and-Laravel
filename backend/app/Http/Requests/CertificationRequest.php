<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificationRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'year' => 'required|integer|min:1950|max:' . date('Y'),
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:certifications_categories,id',
            'credentials' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title may not be greater than 255 characters',
            'organization.required' => 'Organization is required',
            'organization.string' => 'Organization must be a string',
            'organization.max' => 'Organization may not be greater than 255 characters',
            'year.required' => 'Year is required',
            'year.integer' => 'Year must be an integer',
            'year.min' => 'Year must be a proper year format (e.g. 2020)',
            'year.max' => 'Year may not be greater than the current year',
            'description.string' => 'Description must be a string',
            'image.string' => 'Image must be a string',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'credentials.string' => 'Credentials must be a string',
        ];
    }
}
