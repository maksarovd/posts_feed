<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class AcceptedHtmlTags implements Rule
{


    public function passes($attribute, $value)
    {
        $passes = true;

        $value = preg_replace('/<a(?:([\'"]).*?\1|.)*?>/',"<a></a>",$value);
        $value = preg_replace('/<i(?:([\'"]).*?\1|.)*?>/',"<i></i>",$value);
        $value = preg_replace('/<code(?:([\'"]).*?\1|.)*?>/',"<code></code>",$value);
        $value = preg_replace('/<strong(?:([\'"]).*?\1|.)*?>/',"<strong></strong>",$value);


        $matches = ['a', 'i', 'code', 'strong'];

        $tags = preg_match_all('~<([^/][^>]*?)>~', $value, $matches, PREG_PATTERN_ORDER);

        if($tags > 0){
            foreach($matches[0] as $tag){
                if(!in_array($tag,['<a>', '<i>', '<code>', '<strong>']))
                {
                    $passes = false;
                    break;
                }
            }

        }

        return $passes;
    }


    public function message()
    {
        return 'The :attribute use non accessed tags.';
    }
}
