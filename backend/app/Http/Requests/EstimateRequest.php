<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }
    
    public function rules() {

        $id = request()->route()->parameter('id');

        return [
            'client_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'currency' => 'required',
            'estimate_date' => 'required|date',
            'expiry_date' => 'required|date',
            'other_information' => 'nullable',
            'status' => 'nullable',
            'item_id.*' => 'nullable',
            // 'item' => 'required|array',
            // 'description.*' => 'required',
            // 'unit_cost.*' => 'required',
            // 'quantity.*' => 'required',
            // 'amount.*' => 'required',
        ];
    }

    public function messages() {
       return [
            'client_name.required' => 'Client Name is required',
            'company_name.required' => 'Company Name is required',
            'email.required' => 'Email id is required',
            'email.email' => 'Invalid Email Id',
            'mobile.required' => 'Mobile no. is required',
            'mobile.numeric' => 'Mobile no. should be number only',
            'address.required' => 'Address is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'currency.required' => 'Currency is required',
            'estimate_date.required' => 'Estimate Date is required',
            'expiry_date.required' => 'Expiry Date is required',
            // 'item.*.required' => 'Item is required',
            // 'description.*.required' => 'Description is required',
            // 'unit_cost.*.required' => 'Unit Cost is required',
            // 'quantity.*.required' => 'Quantity is required',
            // 'amount.*.required' => 'Amount is required',
        ];
    }
}
