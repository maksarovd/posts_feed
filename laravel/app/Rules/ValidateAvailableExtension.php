<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;


class ValidateAvailableExtension implements Rule
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function passes($attribute, $value)
    {
        $passes = true;

        $filename = $this->request->file('file')->getClientOriginalName();

        $matches = ['txt','jpg','png','gif','jpeg'];

        $result = preg_match_all('/^.+((\.txt)|(\.jpg)|(\.gif)|(\.jpeg)|(\.png))$/i', $filename, $matches, PREG_PATTERN_ORDER);

        if(!$result){
            $passes = false;
        }

        return $passes;
    }


    public function message()
    {
        return 'Only  txt|jpg|png|gif  extensions allowed.';
    }
}
