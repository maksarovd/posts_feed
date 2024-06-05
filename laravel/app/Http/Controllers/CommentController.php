<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse, RedirectResponse};
use Illuminate\View\View;
use App\Models\Comment;
use App\Http\Requests\CheckRequest;


class CommentController extends Controller
{

    /**
     * Index
     *
     *
     * @access public
     * @return View
     */
    public function index(Request $request): View
    {
        return view('comments.index', ['comments' => Comment::comments($request)]);
    }


    /**
     * Create
     *
     *
     * @access public
     * @param Comment $comment
     * @return View
     */
    public function create(Comment $comment = null): View
    {
        return view('comments.create', ['comment' => $comment]);
    }


    /**
     * Show
     *
     *
     * @access public
     * @param Comment $comment
     * @return View
     */
    public function show(Comment $comment): View
    {
        return view('comments.show', ['comments' => $comment->answers($comment->id)]);
    }


    /**
     * Edit
     *
     *
     * @access public
     * @param Comment $comment
     * @return View
     */
    public function edit(Comment $comment): View
    {
        return view('comments.edit', ['comment' => $comment]);
    }


    /**
     * Store
     *
     *
     * @access public
     * @param CheckRequest $request
     * @return RedirectResponse
     */
    public function store(CheckRequest $request): RedirectResponse
    {
        Comment::create($request->all());
        return redirect()->route('comments.index');
    }


    /**
     * Update
     *
     *
     * @access public
     * @param CheckRequest $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(CheckRequest $request, Comment $comment): RedirectResponse
    {
        $comment->fill($request->all())->save();
        return redirect()->route('comments.show', ['comment' => $comment]);
    }


    /**
     * Destroy
     *
     *
     * @access public
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json([]);
    }


    /**
     * Reload Captcha
     *
     *
     * @access public
     * @return JsonResponse
     */
    public function reloadCaptcha(): JsonResponse
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
