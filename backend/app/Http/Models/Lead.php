<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'contact_no', 'address', 'website', 'lead_category_id', 'instagram', 'remarks', 'created_at', 'status'];

    // Accessors
    public function getCreatedAtAttribute($value) {
        return date('d-m-Y h:i A', strtotime($value));
    }

    public static function fetch_leads($request) {

        $leads = Lead::select('leads.*', 'lead_categories.name as lead_category');
        $leads->leftJoin('lead_categories', 'leads.lead_category_id', '=', 'lead_categories.id');
        
        if ($request->status || $request->status == '0') {
            $leads = $leads->where('leads.status', $request->status);
        }

        if ($request->lead_category_id) {
            $leads = $leads->where('leads.lead_category_id', $request->lead_category_id);
        }

        if($request->from && $request->to) {
            $leads = $leads->whereBetween('leads.created_at', [$request->from, $request->to]);
        }

        if($request->sort) {
            $sort_array = explode('/', $request->sort);
            $leads->orderBy('leads.'.$sort_array[0], $sort_array[1]);
        } else {
            $leads->orderBy('leads.created_at', 'desc');
        }

        return $leads->get();
    }

}
