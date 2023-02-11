<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function showImage($fileName)
    {
        $path = public_path().'/storage/user_photo/'.$fileName;
        return Response::download($path);   
    }
    public function showArmadaImage($fileName)
    {
        $path = public_path().'/storage/foto_armada/'.$fileName;
        return Response::download($path);   
    }
}
