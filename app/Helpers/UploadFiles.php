<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UploadFiles
{
    public static function uploadImage($request)
    {
        $image = Str::uuid() . date('Y-m-d') . '.' . $request->getClientOriginalExtension();
        $request->move(public_path('images/'), $image);
        return $image ;
    }

    public static function uploadImageWithFolder($request,$folder,$path)
    {
        $image = Str::uuid() . date('Y-m-d') . '.' . $request->getClientOriginalExtension();
        $request->move(public_path($path.$folder), $image);
        return $image;
    }
}
