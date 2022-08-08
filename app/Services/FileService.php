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
        int $user
        ):object
    {
        $file = File::create([
            'name' => $dto->name,
            'user_id' => $user
        ]);

        return $file;
    }
}