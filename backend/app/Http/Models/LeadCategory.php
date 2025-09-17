<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCategory extends Model {

    public $timestamps = false;

    protected $fillable = ['name'];
    
}
