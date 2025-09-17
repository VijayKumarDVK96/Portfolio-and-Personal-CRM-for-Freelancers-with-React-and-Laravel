<?php

namespace App\Http\Controllers;

use App\Http\Models\Vault;
use App\Http\Models\Clients;
use App\Http\Models\Project;
use Illuminate\Http\Request;
use App\Http\Models\Technology;
use App\Http\Traits\TitleTrait;
use App\Http\Models\ProjectTask;
use App\Http\Models\ProjectGallery;
use App\Http\Models\VaultsCategory;
use App\Http\Requests\VaultRequest;
use App\Http\Traits\FileUploadTrait;
use App\Http\Models\ProjectMilestone;
use App\Http\Models\ProjectsCategory;
use App\Http\Models\TechnologyCategory;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\AddVaultCategoryRequest;
use App\Http\Requests\AddProjectCategoryRequest;
use App\Http\Requests\TechnologyCategoryRequest;
use App\Http\Requests\AddProjectTechnologyRequest;

class ProjectController extends Controller {

    use TitleTrait, FileUploadTrait;

    public $title, $thumbnail_path, $portfolio_path;

    public function __construct() {
        $this->title = $this->fetch_title();
        $this->thumbnail_path = 'images/projects/thumbnail/';
        $this->portfolio_path = 'images/projects/';
    }
    

    /********************/
    /******PROJECTS******/
    /********************/

    public function create_project(ProjectRequest $request) {
        $insert = $request->validated();
        $insert['slug'] = strtolower(str_replace(' ', '-', $request->name));
        $insert['created_at'] = date('Y-m-d H:i:s');

        $project = Project::create($insert);

        foreach ($request->technology as $technology) {
            $project->technologies()->attach([$technology]);
        }

        if ($project) {
            $data = ['status' => 'success', 'message' => 'Project Added'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function read_projects() {
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['all_projects'] = Project::all();
        return view('projects.projects')->with($data);
    }

    public function read_projects_ajax(Request $request) {
        $data['projects'] = Project::read_projects($request);
        $view = view('projects.projects-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['projects'])]);
    }

     public function read_project_details($id) {
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['project'] = Project::read_project_details($id);
        // echo $data['projects'][0]->client->full_name;exit;
        // echo '<pre>';print_r($data['project']);exit;
        return view('projects.project-details')->with($data);
    }

    public function add_project() {
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['categories'] = ProjectsCategory::orderBy('name')->get();
        $data['technology'] = Technology::all();
        return view('projects.add-project')->with($data);
    }

    public function edit_project($id) {
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['clients'] = Clients::orderBy('full_name')->get();
        $data['categories'] = ProjectsCategory::orderBy('name')->get();
        $data['project'] = Project::read_project_details($id);
        $data['technology'] = Technology::all();
        // echo '<pre>';print_r($data['project']);exit;
        return view('projects.edit-project')->with($data);
    }

    public function update_project(ProjectRequest $request) {
        $data = $request->validated();
        $data['slug'] = strtolower(str_replace(' ', '-', $request->name));

        // echo '<pre>';print_r($data);die;

        $project = Project::findOrFail($request->id);
        $project->update($data);

        $technology = Technology::find($request->technology);
        $project->technologies()->sync($technology);

        if ($project) {
            $data = ['status' => 'success', 'message' => 'Project Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }
    
    public function delete_project($id) {
        $project = Project::find($id);

        if ($project->thumbnail_image && file_exists(public_path($this->thumbnail_path . $project->thumbnail_image))) {
            unlink(public_path($this->thumbnail_path . $project->thumbnail_image));
        }
        
        $images = ProjectGallery::where('project_id', $id)->get();
        
        foreach($images as $image) {
            if ($image->name && file_exists(public_path($this->portfolio_path . $image->name))) {
                unlink(public_path($this->portfolio_path . $image->name));
            }
        }
        
        $project->delete();
        
        return response()->json(['status' => 'success', 'message' => 'Project Deleted Successfully']);
    }

    public function upload_thumbnail_image(Request $request) {
        
        $project = Project::find($request->id);

        if ($project->thumbnail_image && file_exists(public_path($this->thumbnail_path . $project->thumbnail_image))) {
            unlink(public_path($this->thumbnail_path . $project->thumbnail_image));
        }
        
        $image = $this->upload($request, $this->thumbnail_path);
        $project->thumbnail_image = $image;
        $project->save();

        return response()->json(['success' => true, 'image' => $this->thumbnail_path.$image]);
    }

    public function upload_portfolio_image(Request $request) {

        $image = $this->upload($request, $this->slider_path);
        
        $project->portfolio_image = $image;
        $project->galleries()->create(['name' => $image, 'position' => 1]);
        
        $new_image = ProjectGallery::where('name', $image)->first(); // To fetch newly inserted image id

        $gallery = ProjectGallery::where('project_id', $request->id)->get();
        
        $temp = 1;
        foreach ($gallery as $key => $value) {
            $gallery = ProjectGallery::find($value->id);
            $gallery->update(['position' => $temp]);
            $temp++;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Portfolio Image Added', 'image' => $this->portfolio_path . $image, 'id' => $new_image->id]);
    }

    public function change_gallery_position(Request $request) {
        $temp = 1;
        for($i=0; $i<count($request->ids); $i++) {
            $gallery = ProjectGallery::find($request->ids[$i]);
            $gallery->update(['position' => $temp]);
            $temp++;
        }
        // echo '<pre>';print_r($request->ids);die;
        $data = ['status' => 'success', 'message' => 'Position Changed'];
        return response()->json($data);
    }

    public function delete_portfolio_image($id) {
        $image = ProjectGallery::find($id);
        
        if ($image->name && file_exists(public_path($this->portfolio_path . $image->name))) {
            unlink(public_path($this->portfolio_path . $image->name));
        }
        
        $image->delete();

        $data = ['status' => 'success', 'message' => 'Portfolio Image Deleted'];

        return response()->json($data);
    }

    /********************/
    /*****CATEGORIES*****/
    /********************/

    public function create_project_category(AddProjectCategoryRequest $request) {
        
        if (ProjectsCategory::create($request->validated())) {
            $categories = ProjectsCategory::orderBy('name')->get();
            $data = ['status' => 'success', 'message' => 'Category Added', 'data' => $categories];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function read_project_categories() {
        $data['title'] = $this->title;
        $data['categories'] = ProjectsCategory::orderBy('name')->get();
        return view('projects.project-categories')->with($data);
    }

    /********************/
    /****TECHNOLOGIES****/
    /********************/

    public function create_technology_category(TechnologyCategoryRequest $request) {
        
        if (TechnologyCategory::create($request->validated())) {
            $categories = TechnologyCategory::all();
            $data = ['status' => 'success', 'message' => 'Category Added', 'data' => $categories];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function update_technology_category(TechnologyCategoryRequest $request) {
        
        $technology = TechnologyCategory::find($request->id);
        $technology->update($request->validated());

        if ($technology) {
            $data = ['status' => 'success', 'message' => 'Category Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function delete_technology_category($id) {
        $category = TechnologyCategory::find($id);
        $category->delete();

        $data = ['status' => 'success', 'message' => 'Category Deleted'];

        return response()->json($data);
    }

    public function create_project_technology(AddProjectTechnologyRequest $request) {
        
        if (Technology::create($request->validated())) {
            $technologies = Technology::all();
            $data = ['status' => 'success', 'message' => 'Technology Added', 'data' => $technologies];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function update_project_technology(AddProjectTechnologyRequest $request) {
        
        $technology = Technology::find($request->id);
        $technology->update($request->validated());

        if ($technology) {
            $data = ['status' => 'success', 'message' => 'Technology Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function read_project_technologies() {
        $data['title'] = $this->title;
        $data['categories'] = TechnologyCategory::all();
        $data['technologies'] = Technology::all();
        return view('projects.project-technologies')->with($data);
    }

    public function delete_technology($id) {
        $technology = Technology::find($id);
        $technology->delete();

        $data = ['status' => 'success', 'message' => 'Technology Deleted'];

        return response()->json($data);
    }

    /**************************/
    /*****VAULT CATEGORIES*****/
    /**************************/

    public function create_vault_category(AddVaultCategoryRequest $request) {
        
        if (VaultsCategory::create($request->validated())) {
            $categories = VaultsCategory::read_vault_categories();
            $data = ['status' => 'success', 'message' => 'Category Added', 'data' => $categories];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function read_vault_categories() {
        $data['title'] = $this->title;
        $data['categories'] = VaultsCategory::read_vault_categories();
        return view('projects.vault-categories')->with($data);
    }

    /**************************/
    /**********VAULT***********/
    /**************************/

    public function create_vault(VaultRequest $request, $id) {
        $project = Project::find($id);
        $project->vault()->create($request->validated());

        $data = ['status' => 'success', 'message' => 'Added new credentials'];

        return response()->json($data);
    }

    public function read_vault($id) {
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['categories'] = VaultsCategory::read_vault_categories();
        return view('projects.vault')->with($data);
    }

    public function read_vault_ajax($id, $category='') {
        $data['vault'] = Vault::read_vault($id, $category);
        $view = view('projects.vault-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view]);
    }

    public function edit_vault($id) {
        $data = Vault::find($id);

        $data = [
            'id' => $data->id,
            'vaults_category_id' => $data->vaults_category_id,
            'url' => $data->url,
            'username' => Crypt::decryptString(
                $data->username),
            'password' => Crypt::decryptString(
                $data->password),
            'notes' => Crypt::decryptString($data->notes),
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update_vault(VaultRequest $request, $id) {
        Vault::find($id)->update($request->validated());

        $data = ['status' => 'success', 'message' => 'Updated credentials'];

        return response()->json($data);
    }

    public function delete_vault($id) {
        $vault = Vault::find($id);
        $vault->delete();

        $data = ['status' => 'success', 'message' => 'Credentials Deleted'];

        return response()->json($data);
    }

    /********************/
    /*****MILESTONES*****/
    /********************/

    public function read_milestone($id) {
        $project = Project::find($id);

        $html = '';

        if(isset($project->project_milestones) && !empty($project->project_milestones)) {
            foreach ($project->project_milestones as $key => $value) {
                if($value->status == 1) {
                    $html .= '<li class="task completed">';
                } else {
                    $html .= '<li class="task">';
                }

                $html .= '<div class="task-container">
                        <h4 class="task-label">'.$value->name.'</h4>
                        <span class="task-action-btn">
                            <span class="action-box large delete-btn" title="Delete Task" onclick="updateMilestone('.$value->id.', "delete")"><i class="icon"><i class="fa fa-times-circle"></i></i></span>
                        
                            <span class="action-box large complete-btn" title="Mark Complete" onclick="updateMilestone('.$value->id.', "update")"><i class="icon"><i class="fa fa-check-square"></i></i></span>
                        </span>
                    </div>
                </li>';
            }
        }

        $data = ['status' => 'success', 'data' => $html];

        return response()->json($data);
    }

    public function create_milestone(Request $request) {
        $project = Project::find($request->id);
        $project->project_milestones()->create([
            'name' => $request->name,
            'status' => 0
        ]);

        $data = ['status' => 'success', 'message' => 'Added new milestone'];

        return response()->json($data);
    }

    public function update_milestone(Request $request) {
        $milestone = ProjectMilestone::find($request->id);

        // echo ($milestone->status == 0) ? 1 : 0;die;

        if($request->type == 'update') {
            $milestone->status = ($milestone->status == 0) ? 1 : 0;
            $milestone->save();
            $message = 'Updated milestone';
        } else if($request->type == 'delete') {
            $milestone->delete();
            $message = 'Deleted milestone';
        } else {
            $message = 'Nothing change';
        }

        $data = ['status' => 'success', 'message' => $message];

        return response()->json($data);
    }

    /********************/
    /*****TASKS*****/
    /********************/

    public function view_tasks($id) {
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['tasks'] = ProjectTask::fetch_tasks($id);
        return view('projects.project-tasks')->with($data);
    }

    public function create_task(Request $request) {
        $project = Project::find($request->id);
        $project->project_tasks()->create([
            'name' => $request->name,
            'status' => 0
        ]);

        $data = ['status' => 'success', 'message' => 'Added new task'];

        return response()->json($data);
    }

    public function update_task(Request $request) {
        $task = ProjectTask::find($request->id);

        // echo ($task->status == 0) ? 1 : 0;die;

        if($request->type == 'update') {
            $task->status = ($task->status == 0) ? 1 : 0;
            $task->save();
            $message = 'Updated task';
        } else if($request->type == 'delete') {
            $task->delete();
            $message = 'Deleted task';
        } else {
            $message = 'Nothing change';
        }

        $data = ['status' => 'success', 'message' => $message];

        return response()->json($data);
    }

}
