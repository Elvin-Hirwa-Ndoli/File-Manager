<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service)
    {
        $userID = Auth::id();

        $uploded = $service->upload($request->dto, $userID);

        return response()->json(["data"=>$uploded,"status"=>200]);
    }

    public function listFile(FileService $service)
    {
        $userID = Auth::id();

        $fileList = $service->list($userID);
        
        return response()->json([$fileList,200]);
    }
}
