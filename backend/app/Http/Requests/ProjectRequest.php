<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {
        $id = request()->route()->parameter('id');

        return [
            'name' => 'required|unique:projects,name,'.$id,
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'client_id' => 'required',
            'projects_category_id' => 'required',
            'estimated_price' => 'required',
            'total_price' => 'nullable',
            'deadline' => 'required',
            'url' => 'nullable',
            'status' => 'nullable',
            'description' => 'nullable',
            'show_on_home' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Project Name is required',
            'name.unique' => 'This Project Name is already added',
            'projects_category_id.required' => 'Category is required',
            'estimated_price.required' => 'Estimated Price is required',
            'client_id.required' => 'Client is required',
            'deadline.required' => 'Deadline is required',
        ];
    }
}
