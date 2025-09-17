<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'position'];

    public function projects() {
        return $this->belongsTo('App\Http\Models\Project');
    }

}
