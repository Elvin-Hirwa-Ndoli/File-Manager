<?php

declare(strict_types=1);

namespace App\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class EditFileRequestDTO extends BaseDTO
{
    public UploadedFile $file;
}