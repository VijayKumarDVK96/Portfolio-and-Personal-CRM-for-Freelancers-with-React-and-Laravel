<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model {

    public $timestamps = false;
    // public $timestamps = ["created_at"];
    // const UPDATED_AT = null; 

    protected $fillable = ['name', 'slug', 'meta_description', 'meta_keywords', 'projects_category_id', 'client_id', 'cover_image', 'description', 'estimated_price', 'total_price', 'demo_url', 'project_url',  'deadline', 'status', 'created_at', 'show_on_home'];

    protected $dates = ['created_at'];

    public function client() {
        return $this->belongsTo('App\Http\Models\Clients');
    }

    public function projects_category() {
        return $this->belongsTo('App\Http\Models\ProjectsCategory');
    }

    public function vault() {
        return $this->hasMany('App\Http\Models\Vault');
    }

    public function project_milestones() {
        return $this->hasMany('App\Http\Models\ProjectMilestone');
    }

    public function project_tasks() {
        return $this->hasMany('App\Http\Models\ProjectTask');
    }

    public function pending_milestones() {
        return $this->project_milestones()->where('status', 0);
    }

    public function completed_milestones() {
        return $this->project_milestones()->where('status', 1);
    }

    public function pending_tasks() {
        return $this->project_tasks()->where('status', 0);
    }

    public function completed_tasks() {
        return $this->project_tasks()->where('status', 1);
    }

    public function technologies() {
        return $this->belongsToMany(Technology::class);
    }

    public function galleries() {
        return $this->hasMany('App\Http\Models\ProjectGallery')->orderBy('position');
    }

    public static function read_projects($request) {
        $projects = Project::select(['id', 'name', 'client_id', 'status', 'deadline', 'created_at'])
        ->with('client:id,full_name')
        ->withCount(['project_milestones', 'pending_milestones', 'completed_milestones', 'project_tasks', 'pending_tasks', 'completed_tasks']);

        if ($request->client_id) {
            $projects->where('client_id', $request->client_id);
        }

        if ($request->project_name) {
            $projects->where('name', $request->project_name);
        }

        if ($request->status) {
            $projects->where('status', $request->status);
        }

        if ($request->sort == 'asc') {
            $projects->oldest();
        } else {
            $projects->latest();
        }

        return $projects->get();
    }

    public static function read_project_details($id) {
        return Project::select(['id', 'name', 'meta_description', 'status', 'thumbnail_image', 'deadline', 'description', 'estimated_price', 'total_price', 'url', 'created_at', 'projects_category_id', 'client_id', 'show_on_home'])
            ->where('id', $id)
            ->with([
                'client:id,full_name',
                'projects_category:id,name',
                'project_milestones',
                'galleries',
                'technologies'
            ])
            ->withCount(['project_milestones', 'pending_milestones', 'completed_milestones', 'project_tasks', 'pending_tasks', 'completed_tasks'])
            ->first(); // id - foreign key

        // return Project::with(['client' => function ($query) {
        //     return $query->select(['id', 'full_name']);
        // }])->where('id', $id)->get();
    }

    public static function read_vault_categories() {
        return DB::table('vaults_categories')->get();
    }

    public static function fetch_projects_for_home() {
        return Project::select(['id', 'url', 'name', 'slug', 'projects_category_id', 'thumbnail_image', 'created_at'])
                        ->where('status', 1)
                        ->where('show_on_home', 1)
                        ->latest()
                        ->get();
    }

    public static function fetch_portfolio_details($id) {
        return Project::where('id', $id)
                        ->with([
                            'client:id,full_name',
                            'projects_category:id,name',
                            'galleries',
                            'technologies'
                        ])
                        ->first();
    }

    public static function fetch_portfolio_details_by_slug($slug) {
        return Project::where('slug', $slug)
                        ->with([
                            'client:id,full_name',
                            'projects_category:id,name',
                            'galleries',
                            'technologies'
                        ])
                        ->first();
    }

}
