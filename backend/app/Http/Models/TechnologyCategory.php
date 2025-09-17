<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnologyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public $table = 'technologies_categories';

    /**
     * Relationship: One Category has many Technologies
     */
    public function technologies()
    {
        return $this->hasMany(Technology::class, 'category_id');
    }
}
