<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Comment;

class SetNestedLevelToComment
{
    const MAX_NESTED_LEVEL = 6;

    public function handle(Request $request, Closure $next): Response
    {
        $parentId = $request->input('parent_id');

        if($parentId){
            $model = Comment::where('id', $parentId)->first();

            if(intVal($model->nested) === self::MAX_NESTED_LEVEL){
                $request->merge(['nested' => ($model->nested - 1)]);
            }
            if(intVal($model->nested) < self::MAX_NESTED_LEVEL){
                $request->merge(['nested' => ($model->nested + 1)]);
            }

        }else{
            $request->merge(['nested' => 1]);
        }



        return $next($request);
    }
}
