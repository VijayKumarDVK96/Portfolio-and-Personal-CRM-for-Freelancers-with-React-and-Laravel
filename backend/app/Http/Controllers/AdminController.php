<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Http\Models\Admin;
use App\Http\Models\Resume;
use App\Http\Models\Enquiry;
use Illuminate\Http\Request;
use App\Http\Models\UserDetail;
use App\Http\Traits\TitleTrait;
use App\Http\Traits\PlacesTrait;
use App\Http\Models\Certification;
use App\Http\Models\PersonalVault;
use App\Http\Models\VaultsCategory;
use App\Http\Traits\ApiHelperTrait;
use App\Http\Requests\ResumeRequest;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\UserDetailsRequest;
use App\Http\Models\CertificationCategory;
use App\Http\Requests\CertificationRequest;
use App\Http\Requests\PersonalVaultRequest;
use App\Http\Requests\CertificationCategoryRequest;

class AdminController extends Controller {

    use PlacesTrait, ApiHelperTrait, TitleTrait, FileUploadTrait;
    public $title, $image_path, $certification_path;

    public function __construct() {
        $this->title = $this->fetch_title();
        $this->image_path = 'images/';
        $this->certification_path = 'images/certifications/';
    }

    public function index() {
        $data['title'] = $this->title;
        $data['counts'] = Admin::counts_summary();
        $data['categories'] = Admin::categories_summary();
        $data['monthly_summary'] = Admin::monthly_summary();
        // echo '<pre>';print_r($data['counts']);die;
        return view('admin.index')->with($data);
    }

    public function my_account() {
        $data['title'] = $this->title;
        $data['details'] = UserDetail::read_user_details(auth()->id());
        return view('admin.my-account')->with($data);
    }

    public function edit_profile() {
        $data['title'] = $this->title;
        $data['details'] = UserDetail::find(auth()->id());
        return view('admin.edit-profile')->with($data);
    }

    public function update_profile(UserDetailsRequest $request) {
        $user = User::find(auth()->id());
        // echo json_encode($request->validated());die;
        $user->user_details()->updateOrCreate(['user_id' => auth()->id()], $request->validated());
        // echo json_encode($user->user_details);die;
        return response()->json(['status' => 'success', 'message' => 'User Details Updated']);
    }

    public function upload_profile_image(Request $request) {
        
        $details = UserDetail::find(auth()->id());
        unlink(public_path($this->image_path.$details->profile_image));
        $request->merge(['type' => 'Profile']);

        $image = $this->upload($request, $this->image_path);
        $details->profile_image = $image;
        $details->save();

        return response()->json(['success' => true, 'image' => $this->image_path.$image]);
    }

    /**************************/
    /**********VAULT***********/
    /**************************/

    public function create_personal_vault(PersonalVaultRequest $request) {
        PersonalVault::create($request->validated());

        $data = ['status' => 'success', 'message' => 'Added new credentials'];

        return response()->json($data);
    }

    public function read_personal_vault() {
        $data['title'] = $this->title;
        $data['categories'] = VaultsCategory::read_vault_categories();
        return view('admin.personal-vault')->with($data);
    }

    public function read_personal_vault_ajax(Request $request) {
        $data['vault'] = PersonalVault::read_personal_vault($request->category);
        // echo '<pre>';print_r($request->category);die;
        $view = view('admin.personal-vault-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view]);
    }

    public function edit_personal_vault($id) {
        $data = PersonalVault::find($id);

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

    public function update_personal_vault(PersonalVaultRequest $request, $id) {
        PersonalVault::find($id)->update($request->validated());

        $data = ['status' => 'success', 'message' => 'Updated credentials'];

        return response()->json($data);
    }

    public function delete_personal_vault($id) {
        $vault = PersonalVault::find($id);
        $vault->delete();

        $data = ['status' => 'success', 'message' => 'Credentials Deleted'];

        return response()->json($data);
    }

    /**************************/
    /********ENQUIRIES*********/
    /**************************/

    public function read_enquiries() {
        $data['title'] = $this->title;
        return view('admin.enquiries')->with($data);
    }

    public function read_enquiries_ajax(Request $request) {
        $data['enquiries'] = Enquiry::read_enquiries($request);
        // echo '<pre>';print_r($request);die;
        $view = view('admin.enquiries-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view]);
    }
    
    public function edit_enquiry($id) {
        $data = Enquiry::find($id);

        $data = [
            'id' => $data->id,
            'status' => $data->status,
            'notes' => $data->notes,
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update_enquiry(Request $request, $id) {
        $data = [
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        Enquiry::find($id)->update($data);

        $data = ['status' => 'success', 'message' => 'Updated Enquiry'];

        return response()->json($data);
    }

    public function delete_enquiry($id) {
        $enquiry = Enquiry::find($id);
        $enquiry->delete();

        $data = ['status' => 'success', 'message' => 'Enquiry Deleted'];

        return response()->json($data);
    }


    /**************************/
    /**********RESUME**********/
    /**************************/


    public function read_resume() {
        $data['title'] = $this->title;
        $data['education'] = Resume::where('type', 'education')->orderBy('from_year', 'desc')->get();
        $data['experience'] = Resume::where('type', 'experience')->orderBy('from_year', 'desc')->get();
        return view('admin.resume')->with($data);
    }

    public function create_resume(ResumeRequest $request) {
        Resume::create($request->validated());
        $data = ['status' => 'success', 'message' => 'Added new resume entry'];

        return response()->json($data);
    }

    public function edit_resume($id) {
        $data = Resume::find($id);

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update_resume(ResumeRequest $request, $id) {
        Resume::find($id)->update($request->validated());
        $data = ['status' => 'success', 'message' => 'Updated resume entry'];

        return response()->json($data);
    }

    public function delete_resume($id) {
        $resume = Resume::find($id);
        $resume->delete();

        $data = ['status' => 'success', 'message' => 'Resume Entry Deleted'];

        return response()->json($data);
    }

    /**************************/
    /******CERTIFICATIONS******/
    /**************************/

    public function create_certification_category(CertificationCategoryRequest $request) {
        CertificationCategory::create($request->validated());
        $data = ['status' => 'success', 'message' => 'Added new category'];

        return response()->json($data);
    }

    public function read_certification_category_ajax() {
        $data['categories'] = CertificationCategory::all();
        $view = view('admin.certification-category-ajax')->with($data)->render();
        // echo '<pre>';print_r($view);die;

        return response()->json(['status' => 'success', 'view' => $view]);
    }

    public function update_certification_category(CertificationCategoryRequest $request, $id) {
        CertificationCategory::find($id)->update($request->validated());
        $data = ['status' => 'success', 'message' => 'Updated category'];

        return response()->json($data);
    }

    public function delete_certification_category($id) {
        $category = CertificationCategory::find($id);
        $category->delete();

        $data = ['status' => 'success', 'message' => 'Category Deleted'];

        return response()->json($data);
    }

    public function read_certifications() {
        $data['title'] = $this->title;
        $data['certifications'] = Certification::with('category')->orderBy('year', 'desc')->get();
        $data['categories'] = CertificationCategory::all();
        return view('admin.certifications')->with($data);
    }

    public function read_certifications_ajax(Request $request) {
        $data['certifications'] = Certification::with('category')->when($request->category, function ($query, $category) {
            return $query->where('category_id', $category);
        })->orderBy('year', 'desc')->get();
        // echo '<pre>';print_r($request->category);die;
        $view = view('admin.certification-list-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view]);
    }

    public function create_certification(CertificationRequest $request) {
        Certification::create($request->validated());
        $data = ['status' => 'success', 'message' => 'Added new certification'];

        return response()->json($data);
    }

    public function edit_certification($id) {
        $data = Certification::find($id);

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update_certification(CertificationRequest $request, $id) {
        Certification::find($id)->update($request->validated());
        $data = ['status' => 'success', 'message' => 'Updated certification'];

        return response()->json($data);
    }

    public function delete_certification($id) {
        $certification = Certification::find($id);
        if ($certification->image && file_exists(public_path($this->certification_path . $certification->image))) {
            unlink(public_path($this->certification_path . $certification->image));
        }
        $certification->delete();

        $data = ['status' => 'success', 'message' => 'Certification Deleted'];

        return response()->json($data);
    }

    public function upload_certification_image($type = null, $id = null, Request $request) {

        // Only for create certification (no id)
        // echo '<pre>';print_r($request->all());die;
        if($type === 'add_certification') {
            $image = $this->upload($request, $this->certification_path);
            return response()->json(['success' => true, 'image' => $this->certification_path . $image]);
            exit;
        }
        
        $certification = Certification::find($request->id);

        if ($certification->image && file_exists(public_path($this->certification_path . $certification->image))) {
            unlink(public_path($this->certification_path . $certification->image));
        }
        
        $image = $this->upload($request, $this->certification_path);
        // $certification->image = $image;
        // $certification->save();

        return response()->json(['success' => true, 'image' => $this->certification_path .$image]);
    }

}