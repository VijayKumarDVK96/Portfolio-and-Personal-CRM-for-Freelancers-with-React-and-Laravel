<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model {

    protected $fillable = ['full_name', 'company_name', 'company_website', 'gender', 'role', 'email', 'mobile', 'address', 'state', 'city', 'created_at'];

    public $timestamps = false;

    // public function projects() {
    //     return $this->belongsToMany('App\Http\Models\Projects');
    // }
    public function projects() {
        return $this->hasMany('App\Http\Models\Project');
    }

    public static function read_clients($request) {
        $clients = Clients::select('clients.*', 'clients.state AS state_id', 'clients.city AS city_id', 'states.name AS state', 'cities.name AS city')
            ->leftJoin('states', 'clients.state', '=', 'states.id')
            ->leftJoin('cities', 'clients.city', '=', 'cities.id');

        if($request->client_id) {
            $clients->where('clients.id', $request->client_id);
        }

        $clients->orderBy('clients.full_name');

        return $clients->paginate(5);
    }

    public static function read_client($id) {
        return Clients::select('clients.*', 'clients.state AS state_id', 'clients.city AS city_id', 'states.name AS state', 'cities.name AS city')
            ->leftJoin('states', 'clients.state', '=', 'states.id')
            ->leftJoin('cities', 'clients.city', '=', 'cities.id')
            ->where(function ($query) use ($id) {
                $query->where('clients.id', $id);
            })
            ->first();
    }

    // Accessor
    public function getFullNameAttribute($value) {
        return ucwords($value);
    }

    public function getCompanyNameAttribute($value) {
        return ucwords($value);
    }

    public function getCompanyWebsiteAttribute($value) {
        return $value ?? '-';
    }

    // Mutator
    public function setEmailAttribute($value) {
        $this->attributes['email'] = strtolower($value);
    }

    public function setWebsiteAttribute($value) {
        $this->attributes['website'] = strtolower($value);
    }
}