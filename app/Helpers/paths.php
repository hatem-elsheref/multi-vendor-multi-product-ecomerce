<?php

// return the full path of the assets of dashboard design
if (!function_exists('adminAssets')){
    function adminAssets($asset){
        return asset('assets/admin/'.$asset);
    }
}

// return the full path of the assets of template-website-front design
if (!function_exists('frontAssets')){
    function frontAssets($asset){
        return asset('assets/front/'.$asset);
    }
}

// return the full path of the uploads
if (!function_exists('uploadedAssets')){
    function uploadedAssets($file){
        return asset($file);
    }
}
