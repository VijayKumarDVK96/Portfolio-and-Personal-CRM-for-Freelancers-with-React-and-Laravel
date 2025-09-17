<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailsRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {
        return [
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'dob' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'nullable',
            'about_me' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'github' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Email id is required',
            'email.email' => 'Invalid Email Id',
            'mobile.required' => 'Mobile no. is required',
            'mobile.numeric' => 'Mobile no. should be number only',
            'dob.required' => 'Date of Birth is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
        ];
    }
}
