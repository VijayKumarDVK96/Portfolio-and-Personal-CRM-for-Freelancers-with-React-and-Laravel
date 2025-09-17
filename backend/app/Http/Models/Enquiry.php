<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'notes', 'created_at', 'updated_at'];

    // Accessors
    public function getCreatedAtAttribute($value) {
        return date('d-m-Y h:i A', strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date('d-m-Y h:i A', strtotime($value));
    }

    public static function read_enquiries($request) {

        $enquiry = Enquiry::select("*");
        if ($request->status) {
            $enquiry = $enquiry->where('status', $request->status);
        }

        if($request->from && $request->to) {
            $enquiry = $enquiry->whereBetween('estimate_date', [$request->from, $request->to]);
        }

        $enquiry->orderBy('created_at', 'desc');

        return $enquiry->get();
    }

}
