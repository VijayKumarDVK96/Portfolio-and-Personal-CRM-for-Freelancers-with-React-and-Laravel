<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateItem extends Model {
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'quantity', 'unit_price', 'total_price'];

    public function estimate() {
        return $this->belongsTo('App\Http\Models\Estimate');
    }
}
