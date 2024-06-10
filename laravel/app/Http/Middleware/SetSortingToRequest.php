<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSortingToRequest
{
    private static array $map = [
        'name'       => 'users.name',
        'email'      => 'users.email',
        'created_at' => 'comments.created_at'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(['sorting' => [
            'sortBy'  => self::$map[$request->get('sortBy','created_at')],
            'orderBy' => $request->get('orderBy','DESC'),
        ]]);

        return $next($request);
    }
}
