<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\UploadFileRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public UploadFileRequestDTO $dto;
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
            'file' => 'required|file|max:100000|mimes:docx,doc,odt,pdf'
        ];
    }

    public function passedValidation()
    {
        
         $validated = $this->validated();
        $this->dto = new UploadFileRequestDTO([
            "file"=> $validated['file']
        ]);
    }
}
