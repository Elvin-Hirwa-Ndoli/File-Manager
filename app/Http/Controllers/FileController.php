<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service) /*object*/
    {

        $userID = Auth::id();

        $response = $service->upload($request->dto, $userID);

        return response()->json($response);
    }

    public function listFile()

    {
      
    }
}
