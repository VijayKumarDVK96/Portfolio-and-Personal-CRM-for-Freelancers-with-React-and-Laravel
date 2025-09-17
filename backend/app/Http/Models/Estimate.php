<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public $timestamps = false;

    protected $fillable = ['estimate_number', 'client_name', 'company_name', 'email', 'mobile', 'address', 'city', 'state', 'country', 'tax', 'amount', 'currency', 'status', 'estimate_date', 'expiry_date', 'description', 'created_at'];

    public function estimate_items() {
        return $this->hasMany('App\Http\Models\EstimateItem');
    }

    public static function fetch_estimate($id) {
        return Estimate::with('estimate_items')->where('id', $id)->first();
    }

    public static function fetch_estimates($request) {

        $estimates = Estimate::select("*");
        
        if ($request->status) {
            $estimates = $estimates->where('status', $request->status);
        }

        if($request->from && $request->to) {
            $estimates = $estimates->whereBetween('estimate_date', [$request->from, $request->to]);
        }

        return $estimates->get();
    }
}
