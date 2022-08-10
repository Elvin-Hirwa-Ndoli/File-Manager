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
        $path = $dto->file->store('MyDocument');
        $file = File::create([
            'name' => $path,
            'user_id' => $userID
        ]);

        return $file;
    }
}