<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;

use App\Services\FileService;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service):object
    {
        // $folder = uniqid() . '-' . now()->timestamp;
        
        $userID = Auth::id();
        
        $response = $service->upload($request->dto,$userID);

        return response()->json($response);

    }
}
