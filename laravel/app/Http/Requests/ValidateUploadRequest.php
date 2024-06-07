<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{ValidateTxtFileSize, ValidateAvailableExtension};


class ValidateUploadRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'file' => [
                new ValidateAvailableExtension($this),
                new ValidateTxtFileSize($this)
            ]
        ];
    }

}


