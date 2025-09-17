<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Http\Request;
use App\Http\Models\Project;
use App\Http\Traits\ApiHelperTrait;
use App\Http\Controllers\Controller;
use App\Http\Models\ProjectsCategory;
use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\AddProjectCategoryRequest;
use App\Http\Requests\AddProjectTechnologyRequest;

class ProjectsApiController extends Controller {

    use ApiHelperTrait;

    /********************/
    /******PROJECTS******/
    /********************/

    public function read_projects() {
        $data['projects'] = Project::read_projects();
        return $this->sendResponse($data, 'success');
    }

    public function read_project_details($id) {
        $data['projects'] = Project::read_project_details($id);
        return $this->sendResponse($data, 'success');
    }

    public function create_project(AddProjectRequest $request) {
        $insert = $request->validated();
        $insert['created_at'] = date('Y-m-d H:i:s');

        if (Project::create($insert)) {
            return $this->sendResponse($insert, 'Project Added');
        } else {
            return $this->sendError('Something Went Wrong', ['Something Went Wrong'], 500);
        }
    }

    /********************/
    /*****CATEGORIES*****/
    /********************/

    public function read_project_categories() {
        $data['categories'] = ProjectsCategory::orderBy('name')->get();
        return $this->sendResponse($data, 'success');
    }

    public function create_project_category(AddProjectCategoryRequest $request) {
        
        if (ProjectsCategory::create($request->validated())) {
            return $this->read_project_categories();
        } else {
            return $this->sendError('Something Went Wrong', ['Something Went Wrong'], 500);
        }

    }

    /********************/
    /****TECHNOLOGIES****/
    /********************/

    public function create_project_technology(AddProjectTechnologyRequest $request) {

        if (DB::table('technologies')->insert($request->validated())) {
            $technologies = DB::table('technologies')->get();
            return $this->sendResponse($technologies, 'Technology Added');
        } else {
            return $this->sendError('Something Went Wrong', ['Something Went Wrong'], 500);
        }
        
    }

    public function read_project_technologies() {
        $data['technologies'] = DB::table('technologies')->get();
        return $this->sendResponse($data, 'success');
    }
}
