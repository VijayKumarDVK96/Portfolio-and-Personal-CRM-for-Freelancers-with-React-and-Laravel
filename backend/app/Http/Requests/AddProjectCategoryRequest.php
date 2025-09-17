<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectCategoryRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {
        return [
            'name' => 'required|unique:projects_categories,name',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Category is Required',
            'name.unique' => 'This Category is already added'
        ];
    }
}
