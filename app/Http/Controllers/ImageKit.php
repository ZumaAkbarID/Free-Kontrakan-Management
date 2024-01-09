<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ImageKit\ImageKit as ImgKit;

class ImageKit extends Controller
{

    protected static $public_key = "public_+ShxgFiv2gJrA0RO5BGjQIDk+aI=";
    protected static $your_private_key = "private_yo08hni35R6cv1ybttiDhE7e/K8=";
    protected static $url_end_point = "https://ik.imagekit.io/kontrakanboys";

    static function upload($base64Image, $imageName, $extension = 'png')
    {
        $imageKit = new ImgKit(
            self::$public_key,
            self::$your_private_key,
            self::$url_end_point
        );

        // Upload Image - base64
        $uploadFile = $imageKit->uploadFile([
            "file" => $base64Image,
            "fileName" => $imageName . '.' . $extension
        ]);

        return json_decode(json_encode($uploadFile), true);
    }
}
