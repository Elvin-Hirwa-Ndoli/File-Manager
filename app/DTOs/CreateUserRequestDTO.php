<?php

declare(strict_types=1);

namespace App\DTOs;

use App\DTOs\BaseDTO;

class CreateUserRequestDTO extends BaseDTO
{
    public string $name;
    public string $email;
    public string $password;
}
