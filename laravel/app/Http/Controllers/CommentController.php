<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Contracts\View\View;
use App\Models\{Comment, File};
use App\Http\Requests\{ValidateUploadRequest, ValidateRequest};
use App\Services\{SortService, UploadImageService};
use Illuminate\Support\Facades\{Storage, Session};


class CommentController extends Controller
{

    /**
     * Index
     *
     *
     * @access public
     * @param SortService $sorter
     * @return View
     */
    public function index(SortService $sorter): View
    {
        return view('comments.index', [
            'comments' => Comment::parentComments(),
            'sorter'   => $sorter
        ]);
    }


    /**
     * Create
     *
     *
     * @access public
     * @param Comment|null $comment
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
        return view('comments.show', ['comment' => $comment]);
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
     * @param ValidateRequest $request
     * @return RedirectResponse
     */
    public function store(ValidateRequest $request): RedirectResponse
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



            Session::flash('message',__('Saving Success!'));
        }catch(\Throwable $exception){
            Session::flash('error',__('Error when saving Comment ') .  $exception->getMessage());
        }
        return redirect()->route('comments.index');
    }


    /**
     * Update
     *
     *
     * @access public
     * @param ValidateRequest $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(ValidateRequest $request, Comment $comment): RedirectResponse
    {
        try{
            $comment->fill($request->except(['file_input', 'file']))->save();

            if($request->file_input){
                $file = [
                    'file_name'  => $request->file_input
                ];

                File::find($comment->file->id)->fill($file)->save();
            }


            Session::flash('message',__('Updating Success!'));
        }catch(\Throwable $exception){
            Session::flash('error',__('Error when updating Comment ') .  $exception->getMessage());
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
            Session::flash('message', __('Deleting Success!'));
        }catch(\Throwable $exception){
            Session::flash('error',__('Error when deleting Comment ') .  $exception->getMessage());
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
     * @access public
     * @param ValidateUploadRequest $request
     * @return JsonResponse
     */
    public function upload(ValidateUploadRequest $request): JsonResponse
    {
        $extension = $request->file->getClientOriginalExtension();
        $name = time() . '.' . $extension;

        if(File::isImage($extension)){
            UploadImageService::upload($extension, $name);
        }

        if(File::isFile($extension)){
            $request->file->storeAs('public/uploads', $name);
        }

        $url = $request->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$name);
        return response()->json(['url' => $url, 'file' => basename($url)]);
    }

}
