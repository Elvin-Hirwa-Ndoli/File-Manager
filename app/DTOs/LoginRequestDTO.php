<?php

declare(strict_types=1);

namespace App\DTOs;

use App\DTOs\BaseDTO;

class LoginRequestDTO extends BaseDTO
{
    public string $email;
    public string $password;
}
