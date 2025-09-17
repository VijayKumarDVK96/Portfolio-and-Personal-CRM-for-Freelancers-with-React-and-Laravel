<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model {
    use HasFactory;

    protected $fillable = ['type', 'title', 'organization', 'location', 'from_year', 'to_year', 'description', 'icon'];
}