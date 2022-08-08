<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service)
    {
        // $folder = uniqid() . '-' . now()->timestamp;
        
        $response = $service->upload($request->dto);

        return response()->json($response);

    }

    public function download(FileService $service, $path)
    {     $response = $service -> download($path);
        return response()->download($response);
      }  
    
}
