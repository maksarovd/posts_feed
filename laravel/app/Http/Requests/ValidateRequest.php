<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{AcceptedHtmlTags, ValidationHtmlTags};

class ValidateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'captcha' => ['required','captcha'],
            'text'    => ['required', 'max:2000', new AcceptedHtmlTags, new ValidationHtmlTags($this)],
        ];
    }

}
