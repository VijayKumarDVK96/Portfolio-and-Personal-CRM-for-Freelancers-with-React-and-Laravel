<?php

namespace App\Http\Controllers;

use App\Http\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Models\LeadStatus;
use App\Http\Traits\TitleTrait;
use App\Http\Models\LeadCategory;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\AddLeadCategoryRequest;
use App\Imports\LeadsImport;
use Maatwebsite\Excel\Facades\Excel;

class LeadsController extends Controller {

    use TitleTrait;

    public $title;

    public function __construct() {
        $this->title = $this->fetch_title();
        $this->thumbnail_path = 'images/projects/thumbnail/';
        $this->portfolio_path = 'images/projects/';
    }

    /********************/
    /*****CATEGORIES*****/
    /********************/

    public function read_leads_categories() {
        $data['title'] = $this->title;
        $data['categories'] = LeadCategory::orderBy('name')->get();
        return view('leads.leads-categories')->with($data);
    }

    public function create_leads_category(AddLeadCategoryRequest $request) {

        if (LeadCategory::create($request->validated())) {
            $categories = LeadCategory::orderBy('name')->get();
            $data = ['status' => 'success', 'message' => 'Category Added', 'data' => $categories];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    /***************/
    /*****LEADS*****/
    /***************/

    public function read_leads() {
        $data['title'] = $this->title;
        $data['categories'] = LeadCategory::orderBy('name')->get();
        return view('leads.leads')->with($data);
    }

    public function read_leads_ajax(Request $request) {
        $data['leads'] = Lead::fetch_leads($request);
        $view = view('leads.leads-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['leads'])]);
    }

    public function add_lead() {
        $data['title'] = $this->title;
        $data['categories'] = LeadCategory::orderBy('name')->get();
        return view('leads.add-lead')->with($data);
    }

    public function create_lead(LeadRequest $request) {
        $insert = $request->validated();
        $insert['created_at'] = date('Y-m-d H:i:s');

        $project = Lead::create($insert);

        if ($project) {
            $data = ['status' => 'success', 'message' => 'Lead Added'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function edit_lead($id) {
        $data['title'] = $this->title;
        $data['lead'] = Lead::where('id', $id)->first();
        $data['categories'] = LeadCategory::orderBy('name')->get();
        return view('leads.edit-lead')->with($data);
    }

    public function update_lead(LeadRequest $request) {
        $update= $request->validated();
        // echo '<pre>';print_r($update);die;

        $lead = Lead::findOrFail($request->id);
        $lead->update($update);

        if ($lead) {
            $data = ['status' => 'success', 'message' => 'Lead Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function delete_lead($id) {
        $lead = Lead::find($id);
        $lead->delete();

        $data = ['status' => 'success', 'message' => 'Lead Deleted'];

        return response()->json($data);
    }

    /**********************/
    /*****LEADS STATUS*****/
    /**********************/

    public function read_leads_status_ajax($id) {
        $data['progress'] = LeadStatus::where('lead_id', $id)->latest()->get();
        $data['lead_id'] = $id;
        $view = view('leads.leads-status-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['progress'])]);
    }

    public function create_lead_status(Request $request) {
        $insert = $request->validate([
            'lead_id' => 'required',
            'remark' => 'required',
        ]);

        $insert['created_at'] = date('Y-m-d H:i:s');

        $status = LeadStatus::create($insert);

        $progress = LeadStatus::where('lead_id', $request->lead_id)->latest()->get();

        $i = 1;
        $values = '';
        foreach ($progress as $key => $value) {
            $values .= '<tr>
                <td>'.$i++.'</td>
                <td>'.$value->remark.'</td>
                <td>'.$value->created_at.'</td>
            </tr>';
        }

        if ($status) {
            $data = ['status' => 'success', 'message' => 'Status Added', 'data' => $values];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    public function delete_lead_status($id) {
        $status = LeadStatus::find($id);
        $status->delete();

        $data = ['status' => 'success', 'message' => 'Status Deleted'];

        return response()->json($data);
    }

    /**********************/
    /*****LEADS IMPORT*****/
    /**********************/

    public function import_leads(Request $request) {
        // Excel::import(new ImportCandidates, $request->file('file'));
        $rows = Excel::toArray(new LeadsImport, $request->file('file'));
        // echo '<pre>';print_r($rows);exit;
        $i = 0;

        foreach ($rows[0] as $value) {
            if($value['name'] && $value['contact_no']) {
                $mobile = str_replace(' ', '', $value['contact_no']);
                $mobile = ltrim($mobile, '0');

                $leads = Lead::where('contact_no', $mobile)->first();
                
                if(isset($leads) && !empty($leads)) {
                    $i++;
                    // return redirect()->back()->with('error', $value['contact_no'] . ' Contact Number is already available');
                } else {
                    if(isset($value['category']) && $value['category'] != '') {
                        $category = ucwords(strtolower($value['category']));
                        $lead_category = LeadCategory::where('name', $category)->first();

                        if(isset($lead_category) && !empty($lead_category)) {
                            $lead_category_id = $lead_category->id;
                        } else {
                            $lead_category_id = LeadCategory::create(['name' => $category]);
                        }
                    } else {
                        $lead_category_id = 1;
                    }

                    if(isset($value['created_at']) && $value['created_at']) {
                        $created_at_array = explode('-', $value['created_at']);
                        $created_at_array = array_reverse($created_at_array);
                        $created_at = implode('-', $created_at_array);
                    } else {
                        $created_at = date('Y-m-d H:i:s');
                    }

                    Lead::create([
                        'name'     => ucwords(strtolower($value['name'])),
                        'contact_no'    => $mobile,
                        'address'    => $value['address'],
                        'website'    => $value['website'],
                        'lead_category_id'    => $lead_category_id,
                        'instagram'    => $value['instagram'],
                        'remarks' => $value['comments'],
                        'created_at' => $created_at,
                    ]);
                }
            }
        }

        $success = 'Data Uploaded';

        if($i) {
            $success .= ', '.$i.' Duplicates Skipped';
        }

        return redirect()->back()->with('success', $success);
    }

    function bulk_action_leads(Request $request) {
        if(isset($request->select) && !empty($request->select) && $request->type != '') {
            if($request->type == 'Delete') {
                Lead::whereIn('id', $request->select)->delete();
                $success = count($request->select).' Leads Deleted';
            } else if($request->type == 'Update') {
                if($request->status == '') {
                    return redirect()->back()->with('error', 'Status is required');
                }

                Lead::whereIn('id', $request->select)->update(['status' => $request->status]);
                $success = count($request->select).' Leads Status Updated';
            }

            return redirect()->back()->with('success', $success);
        } else {
            return redirect()->back()->with('error', 'No lead is selected');
        }
    }
}
