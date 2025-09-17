<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectsCategory extends Model {

    public $timestamps = false;

    protected $fillable = ['name'];

    public function projects() {
        return $this->hasOne('App\Http\Models\Project');
    }

}
