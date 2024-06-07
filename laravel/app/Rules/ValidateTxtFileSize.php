<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;


class ValidateTxtFileSize implements Rule
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function passes($attribute, $value)
    {
        $passes = true;

        if($this->request->file->extension() === 'txt'){
            $bites = $this->request->file('file')->getSize();
            if(($bites/ 1000) > 100){
                $passes = false;
            }
        }

        return $passes;
    }


    public function message()
    {
        return 'The :attribute can`t be greater 100 kb.';
    }
}
