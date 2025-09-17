<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {

        $id = request()->route()->parameter('id');

        return [
            'client_name' => 'required',
            'project_name' => 'required',
            'payment_mode' => 'required',
            'currency' => 'required',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'other_information' => 'nullable',
        ];
    }

    public function messages() {
       return [
            'client_name.required' => 'Client Name is required',
            'project_name.required' => 'Project is required',
            'payment_mode.required' => 'Payment Mode is required',
            'currency.required' => 'Currency is required',
            'invoice_date.required' => 'Invoice Date is required',
            'due_date.required' => 'Due Date is required',
        ];
    }
}
