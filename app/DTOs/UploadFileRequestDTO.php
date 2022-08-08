<?php

declare(strict_types=1);

namespace App\DTOs;

use App\DTOs\BaseDTO;

class UploadFileRequestDTO extends BaseDTO
{
    public string $name;
}
