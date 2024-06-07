<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\{Crypt, Cookie};

class EncryptCookie
{

    public function handle(Request $request, Closure $next): Response
    {
        $findCookieWithoutEncrypting = false;

        if($findCookieWithoutEncrypting){
            //example set encrypt cookie..
            Cookie::queue('currency', Crypt::encrypt('currency'), 15);
        }

        return $next($request);
    }
}
