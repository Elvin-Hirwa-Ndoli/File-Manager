<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request, FileService $service): object
    {
        // $folder = uniqid() . '-' . now()->timestamp;

        $userID = Auth::id();

        // $fileSize = Storage::size($request->dto);

        // dd($fileSize);

        $response = $service->upload($request->dto, $userID);

        return response()->json($response);
    }

    public function listFile(Request $request)

    {
        // $dd= $request->file('file')->getSize();
        // Storage::size($file_path);
        // dd($dd);
        // $files = Storage::allFiles('Docs/MyDocument');
        //    $response = File::all();

        // return $files;

        //         $files = Storage::disk('local')->get();

        //         foreach($files as $file)
        //         {
        // dd($file);
        //         $name = $file->getClientOriginalName();
        //         $extension = $file->getClientOriginalExtension();
        //         }

        //         return $name.$extension;
        // $icons = storage_path('app/MyDocument');
        // $files = scandir($icons);
        // foreach ($files as $file) {
        //     $name = $file->getClientOriginalName();
        //     $extension = $file->getClientOriginalExtension();
        // }

        // return $name;

    //     $file = $request->file('avatar');
 
    // $name = $file->getClientOriginalName(); // Generate a unique, random name...
    // $extension = $file->getClientOriginalExtension(); // Determine the file's extension based on the file's MIME type...

    // return $name;
    }
}
