<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PersonalVault extends Model {

    public $timestamps = false;

    protected $fillable = ['vaults_category_id', 'url', 'username', 'password', 'notes'];

    public function vaults_category() {
        return $this->belongsTo('App\Http\Models\VaultsCategory');
    }

    public static function read_personal_vault($category) {
        $query = PersonalVault::with('vaults_category');

        if ($category) {
            $query->where('vaults_category_id', $category);
        }

        return $query->get();
    }

    // Accessors
    // public function getPasswordAttribute($value) {
    //     return Crypt::decryptString($value);
    // }

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
