<?php
if (!function_exists('cdn_img_url')) {
    function cdn_img_url($path) {
        return 'https://res.cloudinary.com/dhn9skbzx/image/upload/v1701962653/vijaykumardvk/' . $path;
    }
}

if (!function_exists('cdn_asset_url')) {
    function cdn_asset_url($path) {
        return 'https://res.cloudinary.com/dhn9skbzx/raw/upload/v1701962359/vijaykumardvk/' . $path;
    }
}