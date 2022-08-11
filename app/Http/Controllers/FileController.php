<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EditFileRequest;
use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service)
    {
        $userID = Auth::id();

        $uploded = $service->upload($request->dto, $userID);

        return response()->json(["data" => $uploded, "status" => 200]);
    }

    public function listFile(FileService $service)
    {
        $userID = Auth::id();

        $fileList = $service->list($userID);

        return response()->json([$fileList, 200]);
    }

    public function download(FileService $service, int $id)
    {
        $path = $service->download($id);

        Storage::download($path);
    }

    public function destroy(FileService $service, int $id)
    {
        $deleted = $service->destroy($id);

        if ($deleted) {
            return response()->json(["message" => "File successfully deleted"]);
        } else {
            return response()->json(["message" => "Failed to delete file"]);
        }
    }




    public function edit(EditFileRequest $request, FileService $service, int $id)
    {
        try {
            $service->edit($id, $request->dto);

            return response()->json(["message" => "File replace successfully"], 201);
        } catch (\Throwable $th) {

            return response()->json(["msg" => $th->getMessage()], 404);
        }
    }



    public function rename(RenameFileRequest $request, FileService $service, int $id)
    {

        try {

            $service->rename($id, $request->dto);

            return response()->json(["message" => "Successfully renamed"], 200);
        } catch (\Throwable $th) {


            return response()->json(["message" => $th->getMessage()], 404);
        }
    }
}
