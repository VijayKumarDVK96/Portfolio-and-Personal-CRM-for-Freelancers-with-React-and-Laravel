<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model {

    public $timestamps = false;

    protected $fillable = ['vaults_category_id', 'url', 'username', 'password', 'notes'];

    public function projects() {
        return $this->belongsTo('App\Http\Models\Project');
    }

    public function vaults_category() {
        return $this->belongsTo('App\Http\Models\VaultsCategory');
    }

    public static function read_vault($id, $category) {
        $query = Vault::with('vaults_category')->where('project_id', $id);

        if ($category) {
            $query->where('vaults_category_id', $category);
        }

        return $query->get();
    }

    // Mutators
    public function setUsernameAttribute($value) {
        $this->attributes['username'] = Crypt::encryptString($value);
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function setNotesAttribute($value) {
        $this->attributes['notes'] = Crypt::encryptString($value);
    }

}
