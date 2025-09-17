<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Clients;
use App\Http\Traits\ApiHelperTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientsRequest;

class ClientsApiController extends Controller {

    use ApiHelperTrait;
    
    public function index() {
        $data['clients'] = Clients::read_clients();

        return $this->sendResponse($data, 'success');
    }
    
    public function create() {
        //
    }
    
    public function store(ClientsRequest $request) {
        $client = new Clients;
        $client->full_name = $request->full_name;
        $client->company_name = $request->company_name;
        $client->company_website = $request->company_website;
        $client->gender = $request->gender;
        $client->role = $request->role;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->address = $request->address;
        $client->state = $request->state;
        $client->city = $request->city;
        $client->created_at = date('Y-m-d h:i:s');
        $client->save();

        return $this->sendResponse($client, 'New Client Created');
    }
    
    public function show($id) {
        $data['clients'] = Clients::read_client($id);

        return $this->sendResponse($data, 'success');
    }
    
    public function edit($id) {
        //
    }
    
    public function update(ClientsRequest $request, $id) {
        $client = Clients::find($id);

        if (!$client)
            return $this->sendError('Client Not Found', ['Client Not Found'], 404);

        $client->full_name = $request->full_name;
        $client->company_name = $request->company_name;
        $client->company_website = $request->company_website;
        $client->gender = $request->gender;
        $client->role = $request->role;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->address = $request->address;
        $client->state = $request->state;
        $client->city = $request->city;
        $client->updated_at = date('Y-m-d h:i:s');
        $client->save();

        return $this->sendResponse($client, 'Client Details Updated');
    }
    
    public function destroy($id) {
        $client = Clients::find($id);

        if (!$client)
            return $this->sendError('Client Not Found', ['Client Not Found'], 404);

        $client->delete();

        return $this->sendResponse($client, 'Client Details Deleted');
    }
}
