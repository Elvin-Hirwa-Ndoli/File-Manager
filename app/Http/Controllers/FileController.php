<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EditFileRequest;
use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class FileController extends Controller
{
   

    public function upload(UploadFileRequest $request, FileService $service)
    {
        $userID = Auth::id();

        $uploded = $service->upload($request->dto, $userID);

        return response()->json($uploded);
    }

    public function listFile()

    {
    }

    public function edit(EditFileRequest $request, FileService $service, int $id)
    {
        try {

            
            $result = $service->edit($id, $request->dto);

            return response()->json($result,201);
        } catch (\Throwable $th) {

            return response()->json(["msg" => $th->getMessage()], 404);
        }

        
    }



    public function rename(RenameFileRequest $request,FileService $service, int $id)
    {

     try {

        $result =$service->rename($id , $request->dto);

        return response()->json(["message"=>$result],200);

        
     } catch (\Throwable $th) {
       
        return response()->json(["message" => $th->getMessage()], 404);
     }

    }
    
}
