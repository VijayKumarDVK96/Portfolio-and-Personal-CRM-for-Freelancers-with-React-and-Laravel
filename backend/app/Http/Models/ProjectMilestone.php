<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMilestone extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'status'];

    public function projects() {
        return $this->belongsTo('App\Http\Models\Project');
    }

}
