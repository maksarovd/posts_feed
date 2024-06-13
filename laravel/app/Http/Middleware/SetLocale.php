<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->language ?? 'en';

        $locales = [];
        foreach(['en', 'ua'] as $language){
            if($language !== $locale){
                $locales[$language] = str_replace('/'.$locale.'/', '/'.$language.'/', url()->current());
            }
        }

        $request->merge(['locales' => $locales]);

        App::setLocale($locale);

        return $next($request);
    }
}
