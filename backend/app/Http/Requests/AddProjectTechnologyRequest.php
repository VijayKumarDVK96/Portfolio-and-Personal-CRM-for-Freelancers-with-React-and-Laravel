<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectTechnologyRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        $id = request()->route()->parameter('id');

        return [
            'name' => 'required|unique:technologies,name,' . $id,
            'category_id' => 'required|exists:technologies_categories,id',
            'logo' => 'required',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Technology is Required',
            'name.unique' => 'This Technology is already added',
            'category_id.required' => 'Category is Required',
            'category_id.exists' => 'Selected Category does not exist',
            'logo.required' => 'Logo URL is Required',
        ];
    }
}
