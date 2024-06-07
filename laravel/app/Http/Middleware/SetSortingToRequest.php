<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSortingToRequest
{

    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(['sorting' => [
            'sortBy'  => $request->get('sortBy','created_at'),
            'orderBy' => $request->get('orderBy','DESC'),
        ]]);

        return $next($request);
    }
}
