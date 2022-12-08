<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    function upload(Request $request){
        $file = $request->file('files');
        $pathName = (!empty($folder) ? $folder . "/" : "") . $file->getClientOriginalName();
        $path = Storage::disk('public')->putFileAs("images", $file, $pathName);
        return $path;
    }
}
