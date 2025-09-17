<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        $id = request()->route()->parameter('id');

        return [
            'name' => 'required',
            'contact_no' => 'required|numeric|unique:leads,contact_no,' . $id,
            'address' => 'required',
            'website' => 'nullable',
            'lead_category_id' => 'required|numeric',
            'instagram' => 'nullable',
            'remarks' => 'nullable',
            'status' => 'nullable'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Name is required',
            'contact_no.required' => 'Contact No. is required',
            'contact_no.unique' => 'This Contact No. is already added',
            'address.required' => 'Address is required',
            'lead_category_id.required' => 'Category is required',
        ];
    }
}
