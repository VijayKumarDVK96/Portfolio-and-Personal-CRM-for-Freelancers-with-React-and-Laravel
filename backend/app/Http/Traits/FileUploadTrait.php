<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;

trait FileUploadTrait {

    public function upload(Request $request, $folder) {

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = ($request->type == 'Profile') ? 'vijay-kumar-dvk' . '.' . $image_type : uniqid() . '.' . $image_type;

        $imageFullPath = public_path($folder) . $imageName;

        file_put_contents($imageFullPath, $image_base64);

        return $imageName;
    }

    public function delete($name, $folder) {

        $path = $folder.$name;
        if (file_exists($path)) {
            @unlink($path);
        }

        return true;
    }
    
}
