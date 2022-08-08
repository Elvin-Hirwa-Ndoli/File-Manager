<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class FileController extends Controller
{
    public function download()
    {
    	$path = public_path('file.zip');
    	$fileName = 'file.zip';
        $headers = ['Content-Type: application/zip'];
    	return Response::download($path, $fileName,$headers );
    }
}