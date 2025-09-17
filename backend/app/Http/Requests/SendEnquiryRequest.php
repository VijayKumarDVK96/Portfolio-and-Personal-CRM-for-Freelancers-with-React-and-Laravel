<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEnquiryRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {
        return [
            'name' => 'required|min:5',
            'email' => 'required|min:5|email',
            'phone' => 'required|min:8',
            'subject' => 'required|min:5',
            'message' => 'required'
        ];
    }
}
