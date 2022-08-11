<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\EditFileRequestDTO;
use App\DTOs\RenameFileRequestDTO;
use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function upload(
        UploadFileRequestDTO $dto,
        int $userID
    ): File {
        $name = $dto->file->getClientOriginalName();

        $fileName = pathinfo($name, PATHINFO_FILENAME);

        $extension = $dto->file->getClientOriginalExtension();

        $size = $dto->file->getSize();

        $path = $dto->file->store('MyDocument');

        return File::create([
            'path' => $path,
            'name' => $fileName,
            'extension' => $extension,
            'size' => $size,
            'user_id' => $userID,

        ]);
    }




    public function list(int $userID)
    {
        return File::where('user_id', $userID)->paginate(2);
    }


    /**
     * @throws Exception
     */
    public function download(int $id): string
    {

        $file = File::where('id', $id)->first();

        return $file->name;
    }

    public function destroy(int $id): bool
    {

        $file = File::where('id', $id)->first();

        $path = $file->name;

        Storage::delete($path);

        return File::find($file->id)->delete();
    }

    public function edit(
        int $id,
        EditFileRequestDTO $dto
    ): void {

        $path =  $dto->file->store('MyDocument');

        $extension = $dto->file->getClientOriginalExtension();

        $size = $dto->file->getSize();

        $old_file =  File::where('id', $id)->first();


        if (is_null($old_file)) {

            throw new Exception("The file does not exist");
        }

        Storage::delete($old_file->path);

        File::whereId($id)->update(['path' => $path, 'size' => $size, 'extension' => $extension]);
    }

    /**
     * @throws Exception
     */

    public function rename(
        int  $id,
        RenameFileRequestDTO $dto
    ): void {
        $name = $dto->name;
        $old_file =  File::where('id', $id)->first();

        if (is_null($old_file)) {

            throw new Exception("The file does not exist");
        }

        File::whereId($id)->update(['name' => $name]);
    }
}
