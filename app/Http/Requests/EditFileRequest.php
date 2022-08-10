<?php

namespace App\Http\Requests;

use App\DTOs\EditFileRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class EditFileRequest extends FormRequest
{
    public EditFileRequestDTO $dto;

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

        $this->dto = new EditFileRequestDTO([
            "file" => $validated['file']
        ]);

    }
}
