<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model {

    protected $fillable = [
        'name', 'category_id', 'logo'
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(TechnologyCategory::class, 'category_id');
    }
}
