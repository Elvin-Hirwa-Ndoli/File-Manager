<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\LoginRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public LoginRequestDTO $dto;
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
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function passedValidation()
    {
        $this->dto = new LoginRequestDTO($this->validated());
    }
}
