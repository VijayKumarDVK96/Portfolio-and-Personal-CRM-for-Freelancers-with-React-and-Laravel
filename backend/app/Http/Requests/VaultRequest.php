<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaultRequest extends FormRequest {

    public function authorize() {
        return true;
    }
    
    public function rules() {
        return [
            'vaults_category_id' => 'required',
            'url' => 'required',
            'username' => 'required',
            'password' => 'required',
            'notes' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'vaults_category_id.required' => 'Category is required',
            'url.required' => 'URL is required',
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
        ];
    }

}
