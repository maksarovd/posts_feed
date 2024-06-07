<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSortingToRequest
{

    public function handle(Request $request, Closure $next): Response
    {
        $sorting = [
            'sortBy'  => $request->get('sortBy')  ?? 'created_at',
            'orderBy' => $request->get('orderBy') ?? 'DESC',
        ];


        $request->merge(['sorting' => $sorting]);

        return $next($request);
    }
}
