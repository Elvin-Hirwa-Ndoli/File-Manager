<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EditFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service):object
     {
        $userID = Auth::id();
        
        $response = $service->upload($request->dto,$userID);

        return response()->json($response);
    }


    public function edit(EditFileRequest $request, FileService $service, $id)
    {
        try {
            $result = $service->edit($id, $request->dto);
        } catch (\Throwable $th) {

            return response()->json(["msg" => 'file not found'], 404);
        }

        return response()->json(["data" => $result]);
    }



    public function rename(Request $request, $id)
    {

        $old_file =  File::where('id', $id)->first();

        $path = $old_file;
    }
}
