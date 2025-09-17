<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model {
    use HasFactory;

    protected $fillable = ['title', 'organization', 'year', 'description', 'credentials', 'image', 'category_id'];

    public function category() {
        return $this->belongsTo(CertificationCategory::class, 'category_id');
    }
}
