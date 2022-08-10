<?php

namespace App\Http\Requests;

use App\DTOs\RenameFileRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class RenameFileRequest extends FormRequest
{

    public RenameFileRequestDTO $dto;

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


            "name"=>'required|string'
        ];
    }
    
    public function passedValidation()
    {
        $this->dto = new RenameFileRequestDTO($this->validated());


    }
}
