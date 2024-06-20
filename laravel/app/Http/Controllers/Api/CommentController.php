<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Comment as CommentResource;


class CommentController extends Controller
{

    public function index()
    {
        return CommentResource::collection(Comment::where('parent_id',null)->paginate(25));
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Comment $comment)
    {
        //
    }


    public function update(Request $request, Comment $comment)
    {
        //
    }


    public function destroy(Comment $comment)
    {
        //
    }

}
