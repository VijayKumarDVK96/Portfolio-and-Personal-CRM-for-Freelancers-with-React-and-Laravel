<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VaultsCategory extends Model {

    public $timestamps = false;

    protected $fillable = ['name'];

    public function vault() {
        return $this->hasOne('App\Http\Models\Vault');
    }

    public static function read_vault_categories() {
        return VaultsCategory::all();
    }

}
