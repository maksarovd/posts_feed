<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse, RedirectResponse};
use Illuminate\View\View;
use App\Models\{Comment, File};
use App\Http\Requests\{ValidateUploadRequest, CheckRequest};
use App\Services\CommentService;
use Illuminate\Support\Facades\{Storage, Session};


class CommentController extends Controller
{

    /**
     * Index
     *
     *
     * @access public
     * @param Request $request
     * @param CommentService $commentService
     * @return View
     */
    public function index(Request $request, CommentService $commentService): View
    {
        $sorting = $request->get('sorting');

        return view('comments.index', [
            'comments' => Comment::comments($sorting),
            'comment_service' => $commentService
        ]);
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
     * @param CommentService $commentService
     * @return View
     */
    public function show(Comment $comment, CommentService $commentService): View
    {
        return view('comments.show', [
            'comment'  => $comment,
            'comments' => $comment->answers($comment->id),
            'comment_service' => $commentService
        ]);
    }


    /**
     * Edit
     *
     *
     * @access public
     * @param Comment $comment
     * @param CommentService $commentService
     * @return View
     */
    public function edit(Comment $comment, CommentService $commentService): View
    {
        return view('comments.edit', [
            'comment' => $comment,
            'comment_service' => $commentService
        ]);
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
        try{
            (new Comment)->fill($request->except(['file_input', 'file']))->save();

            if($request->file_input){
                $file = [
                    'comment_id' => Comment::latest()->first()->id,
                    'file_name'  => $request->file_input
                ];

                File::create($file);
            }



            Session::flash('message','Saving Success!');
        }catch(\Throwable $exception){
            Session::flash('error','Error when saving Comment ' .  $exception->getMessage());
        }
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
        try{
            $comment->fill($request->except(['file_input', 'file']))->save();

            if($request->file_input){
                $file = [
                    'file_name'  => $request->file_input
                ];

                File::find($comment->file->id)->fill($file)->save();
            }


            Session::flash('message','Updating Success!');
        }catch(\Throwable $exception){
            Session::flash('error','Error when updating Comment ' .  $exception->getMessage());
        }
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
        try{
            $comment->delete();
            Session::flash('message','Deleting Success!');
        }catch(\Throwable $exception){
            Session::flash('error','Error when deleting Comment ' .  $exception->getMessage());
        }
        return response()->json(['url' => route('comments.index')]);
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
        return response()->json(['captcha' => captcha_img('characters')]);
    }


    /**
     * Upload
     *
     *
     * @param ValidateUploadRequest $request
     * @return JsonResponse
     */
    public function upload(ValidateUploadRequest $request): JsonResponse
    {
        $name = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->storeAs('public/uploads', $name);
        $url  = $request->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$name);
        return response()->json(['url' => $url, 'file' => basename($url)]);
    }
}