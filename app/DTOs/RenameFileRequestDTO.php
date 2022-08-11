<?php

declare(strict_types=1);

namespace App\DTOs;

use App\DTOs\BaseDTO;

class RenameFileRequestDTO extends BaseDTO
{
    public string $name;
}