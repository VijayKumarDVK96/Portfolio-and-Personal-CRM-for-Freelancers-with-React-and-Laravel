<?php

namespace App\Http\Controllers;

use App\Http\Models\Clients;
use App\Http\Requests\ClientsRequest;
use App\Http\Traits\PlacesTrait;
use App\Http\Traits\TitleTrait;
use Illuminate\Http\Request;

class ClientsController extends Controller {

    use PlacesTrait, TitleTrait;

    public $title;

    public function __construct() {
        $this->title = $this->fetch_title();
    }

    /********************/
    /*******CREATE*******/
    /********************/

    public function generate_fake_clients() {
        factory(Clients::class)->create();
    }

    public function create_client(ClientsRequest $request) {
        $data = $request->validated();
        $data['created_at'] = date('Y-m-d H:i:s');

        // echo '<pre>';print_r($data);exit;

        if (Clients::create($data)) {
            $data = ['status' => 'success', 'message' => 'New Client Created'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    /********************/
    /********READ********/
    /********************/

    public function fetch_clients(Request $request) {
        $data = Clients::select('id', 'full_name')->where('full_name', 'like', '%'.$request->term.'%')->orderBy('full_name')->get();

        if (empty($data)) {
            $data[] = array("value" => "");
        }
        
        echo json_encode($data);
    }

    public function read_clients() {
        $data['title'] = $this->title;
        return view('clients.clients')->with($data);
    }

    public function read_clients_ajax(Request $request) {
        $data['states'] = $this->states();
        $data['cities'] = $this->cities();
        $data['clients'] = Clients::read_clients($request);
        $view = view('clients.clients-ajax')->with($data)->render();

        return response()->json(['status' => 'success', 'view' => $view, 'count' => count($data['clients'])]);
    }

    public function add_client() {
        $data['title'] = $this->title;
        $data['state_id'] = 35;
        $data['states'] = $this->states();
        return view('clients.client-add')->with($data);
    }

    /********************/
    /*******UPDATE*******/
    /********************/

    public function update_client(ClientsRequest $request) {
        if (Clients::findOrFail($request->id)->update($request->validated())) {
            $data = ['status' => 'success', 'message' => 'Client Details Updated'];
        } else {
            $data = ['status' => 'error', 'message' => 'Something Went Wrong'];
        }

        return response()->json($data);
    }

    /********************/
    /*******DELETE*******/
    /********************/

    public function delete_client(Request $request) {
        Clients::findOrFail($request->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Client Details Deleted']);
    }

}
