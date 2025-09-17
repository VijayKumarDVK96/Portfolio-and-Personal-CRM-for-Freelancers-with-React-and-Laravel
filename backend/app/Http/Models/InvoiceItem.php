<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model {
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'quantity', 'unit_price', 'total_price'];

    public function estimate() {
        return $this->belongsTo('App\Http\Models\Invoice');
    }
}
