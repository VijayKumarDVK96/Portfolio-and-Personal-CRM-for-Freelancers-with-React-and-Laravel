<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {

        $id = request()->route()->parameter('id');

        return [
            'client_id' => 'required',
            'project_id' => 'required',
            'paid_amount' => 'required',
            'paid_at' => 'required|date',
            'payment_type' => 'required',
            'statement_type' => 'required',
            'purpose' => 'required',
            'description' => 'nullable',
        ];
    }

    public function messages() {
       return [
            'client_id.required' => 'Client Name is required',
            'project_id.required' => 'Project is required',
            'paid_amount.required' => 'Paid Amount is required',
            'paid_at.required' => 'Paid At is required',
            'payment_type.required' => 'Payment Type is required',
            'statement_type.required' => 'Payment Type is required',
            'purpose.required' => 'Purpose is required',
        ];
    }

}
