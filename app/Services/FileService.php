<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\returnSelf;

class FileService
{
    public function upload(
        UploadFileRequestDTO $dto,
        int $userID
        ):object
    {
        $file = File::create([
            'name' => $dto->name,
            'user_id' => $userID
        ]);

        return $file;
    }

    /**
     * @throws Exception
     */
    public function download(int $id)
    {

        $file = File::where('id', $id)->first();

        $path= $file->name;
        
        Storage::download($path);

        return $path;
    
    }

    public function destroy(int $id)
    {
    

        $file = File::where('id', $id)->first();
        
        $path= $file->name;

        Storage::delete($path);

        File::find($file->id)->delete();

        return ["deleted"];

    


        

    }
}