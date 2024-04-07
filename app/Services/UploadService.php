<?php

namespace App\Services;

use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UploadService
{
    public static function upload($file, $folder, $name)
    {
        if ($file) {

            // Store on local server if file is not image or video
            $directoryPath = 'uploads/'.$folder;
            $publicURL = 'uploads/'.$folder;
            $fileName = $name.'-'.Str::random(10).'.'.$file->extension();

            $send = $file->move($directoryPath, $fileName);

            if ($send) {
                return asset($publicURL.'/'.$fileName);
            }
        }

        return 'Error';
    }

    // private static function fileExt($ext){
	// 	$imgs = array("jpeg", "jpg", "png", "gif", "tiff", "tif");
	// 	$videos = array("flv", "avi", "mov", "mp4", "mp3", "mpg", "wmv", "3gp", "asf");

	//     if(in_array($ext, $imgs)) {
	//       	return 'img';
	//     }
	//     elseif(in_array($ext, $videos)){
	//     	return 'video';
	//     }

    //     return false;
	// }

}
