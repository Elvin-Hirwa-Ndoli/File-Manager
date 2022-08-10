<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileService
{
    public function upload(
        UploadFileRequestDTO $dto,
        int $userID
        ):File
    {
        $name = $dto->file->getClientOriginalName();

        $extension = $dto->file->getClientOriginalExtension();

        $size = $dto->file->getSize();

        $path = $dto->file->store('MyDocument');
        
        $file = File::create([
            'path' => $path,
            'name' => $name,
            'extension' => $extension,
            'size' => $size,
            'user_id' => $userID,
            
        ]);

        return $file;
    }



    public function list(int $userID)
    {
        $file = File::where('user_id', $userID)->paginate(2);

        return $file;
    }
}