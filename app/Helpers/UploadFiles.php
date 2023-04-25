<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UploadFiles
{
    public static function uploadimage($request)
    {
        $image = Str::uuid() . date('Y-m-d') . '.' . $request->getClientOriginalExtension();
        $request->move(public_path('images/'), $image);
        return $image ;
    }
}
