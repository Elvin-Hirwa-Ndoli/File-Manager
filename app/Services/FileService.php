<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\EditFileRequestDTO;
use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function edit(
        int $id,
        EditFileRequestDTO $dto
    ) {

        $path =  $dto->file->store('MyDocument');
        $old_file =  File::where('id', $id)->first();


        if (is_null($old_file)) {

            throw new Exception("The file does not exist");
        }

        Storage::delete($old_file->name);


        File::whereId($id)->update(['name' => $path]);
    }
}
