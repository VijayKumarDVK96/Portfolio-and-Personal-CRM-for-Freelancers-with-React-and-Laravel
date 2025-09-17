<?php
namespace App\Http\Traits;

trait TitleTrait {

    public function fetch_title() {
        if(isset($_SERVER['REQUEST_URI'])) {
            $replace_dash = str_replace('-', ' ', $_SERVER['REQUEST_URI']);
            $route_array = explode('/', $replace_dash);
            $title = is_numeric(end($route_array)) ? ucwords($route_array[count($route_array)-2]) : ucwords(end($route_array));
            return ($title == 'Admin') ? 'Dashboard' : $title;
        } else {
            return true;
        }
    }
    
}
