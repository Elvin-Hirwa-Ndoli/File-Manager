<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\CreateUserRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public CreateUserRequestDTO $dto;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ];
    }


    public function passedValidation()
    {
        $this->dto = new CreateUserRequestDTO($this->validated());
    }
}
