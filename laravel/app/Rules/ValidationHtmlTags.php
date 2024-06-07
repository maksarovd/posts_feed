<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;


class ValidationHtmlTags implements Rule
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function passes($attribute, $value)
    {
        $passes = true;

        if(extension_loaded('tidy')){
            $tidy = new \Tidy();
            $tidy->parseString($value, ['show-body-only' => true], 'utf8');
            $tidy->cleanRepair();

            $this->request->merge(['text' => $tidy->value]);
        }

        return $passes;
    }


    public function message()
    {
        return 'never used..';
    }
}
