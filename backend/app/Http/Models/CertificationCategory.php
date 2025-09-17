<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationCategory extends Model {
    
    use HasFactory;

    protected $fillable = ['name'];

    public $table = 'certifications_categories';

    public function certifications() {
        return $this->hasMany(Certification::class, 'category_id');
    }
}
