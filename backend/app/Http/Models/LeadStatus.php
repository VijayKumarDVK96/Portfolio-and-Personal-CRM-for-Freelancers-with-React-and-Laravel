<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model {

    public $timestamps = false;

    protected $fillable = ['remark', 'lead_id', 'created_at'];

    // Accessors
    public function getCreatedAtAttribute($value) {
        return date('d-m-Y h:i A', strtotime($value));
    }
}
