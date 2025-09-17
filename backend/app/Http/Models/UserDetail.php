<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserDetail extends Model implements HasMedia {

    use InteractsWithMedia;

    public $timestamps = false;

    protected $fillable = ['email', 'mobile', 'dob', 'city', 'state', 'country', 'about_me', 'linkedin', 'instagram', 'github', 'profile_image', 'cover_image'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function read_user_details($id) {
        return UserDetail::select('user_details.*', 'user_details.state', 'user_details.city')
            ->where('user_id', $id)
            ->first();
    }

}
