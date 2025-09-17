<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {
        $id = request()->route()->parameter('id');

        return [
            'full_name' => 'required',
            'company_name' => 'required',
            'company_website' => 'url',
            'gender' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:clients,email,'.$id,
            'mobile' => 'required|numeric',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
        ];
    }

    public function messages() {
        return [
            'full_name.required' => 'Name is required',
            'company_name.required' => 'Company Name is required',
            'company_website.required' => 'Company Website is required',
            'company_website.url' => 'Company Website should be url type',
            'gender.required' => 'Gender is required',
            'role.required' => 'Role is required',
            'email.required' => 'Email id is required',
            'email.email' => 'Invalid Email Id',
            'email.unique' => 'This Email Id is already registered with clients',
            'mobile.required' => 'Mobile no. is required',
            'mobile.numeric' => 'Mobile no. should be number only',
            'address.required' => 'Address is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
        ];
    }
}
