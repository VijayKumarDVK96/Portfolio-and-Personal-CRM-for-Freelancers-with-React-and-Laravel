<?php
namespace App\Http\Traits;
use DB;

trait PlacesTrait {
    
    function states() {
        return DB::table('states')->get();
    }

    function cities($state_id = '35') {
        return DB::table('cities')->where('state_id', $state_id)->get();
    }

    function show_cities($state_id) {
        $cities = $this->cities($state_id);
        
        $city = '<option value="">Select City</option>';
        foreach($cities as $value) {
            $city .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }

        echo $city;
    }
}
