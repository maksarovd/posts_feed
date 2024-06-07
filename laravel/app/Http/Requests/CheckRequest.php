<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AcceptedHtmlTags;

class CheckRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'captcha' => ['required','captcha'],
            'text'    => ['required', 'max:2000', new AcceptedHtmlTags],
        ];
    }

}
