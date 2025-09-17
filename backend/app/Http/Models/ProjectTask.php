<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model {
    public $timestamps = false;

    protected $fillable = ['name', 'status'];

    public function projects() {
        return $this->belongsTo('App\Http\Models\Project');
    }

    public static function fetch_tasks($id) {
        return ProjectTask::where('project_id', $id)->orderBy('status', 'desc')->get();
    }
}
