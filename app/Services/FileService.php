<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\EditFileRequestDTO;
use App\DTOs\RenameFileRequestDTO;
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
    ): File {
        $name = $dto->file->getClientOriginalName();

        $fileName = pathinfo($name,PATHINFO_FILENAME);

        $extension = $dto->file->getClientOriginalExtension();

        $size = $dto->file->getSize();

        $path = $dto->file->store('MyDocument');

        $file = File::create([
            'path' => $path,
            'name' => $fileName,
            'extension' => $extension,
            'size' => $size,
            'user_id' => $userID,

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

        $extension = $dto->file->getClientOriginalExtension();

        $size = $dto->file->getSize();

        $old_file =  File::where('id', $id)->first();


        if (is_null($old_file)) {

            throw new Exception("The file does not exist");
        }

        Storage::delete($old_file->path);


        File::whereId($id)->update(['path' => $path, 'size' => $size, 'extension' => $extension]);

        return true;
    }

     /**
     * @throws Exception
     */

    public function rename(
        int  $id,
        RenameFileRequestDTO $dto
    ) {
        $name = $dto->name;
        $old_file =  File::where('id', $id)->first();

        if(is_null($old_file)) {

            throw new Exception("The file does not exist");

        }

        File::whereId($id)->update(['name' =>$name]);

        return true;
    }
}
