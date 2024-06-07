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
            'comments' => Comment::parentComments($sorting),
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
     * @access public
     * @param ValidateUploadRequest $request
     * @return JsonResponse
     */
    public function upload(ValidateUploadRequest $request): JsonResponse
    {
        $ext  = $request->file->getClientOriginalExtension();
        $name = time().'.'.$ext;

        if($request->file->getClientOriginalExtension() != File::TXT_FILE_EXTENSION){
            if (move_uploaded_file($_FILES['file']['tmp_name'], $name)) {

                if($ext === File::GIF_FILE_EXTENSION){
                    $uploadedImage = imagecreatefromgif($name);
                }
                if($ext === File::JPEG_FILE_EXTENSION || $ext === File::JPG_FILE_EXTENSION){
                    $uploadedImage = imagecreatefromjpeg($name);
                }
                if($ext === File::PNG_FILE_EXTENSION){
                    $uploadedImage = imagecreatefrompng($name);
                }


                if (!$uploadedImage) {
                    throw new Exception('The uploaded file is corrupted (or wrong format)');
                } else {
                    $resizedImage = $this->PIPHP_ImageResize($uploadedImage,File::MEDIA_FILE_WIDTH,File::MEDIA_FILE_HEIGHT);


                    if($ext === File::GIF_FILE_EXTENSION){
                        if (!imagegif ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                            throw new Exception('failed to save resized image');
                        }
                    }
                    if($ext === File::JPEG_FILE_EXTENSION || $ext === File::JPG_FILE_EXTENSION){
                        if (!imagejpeg ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                            throw new Exception('failed to save resized image');
                        }
                    }
                    if($ext === File::PNG_FILE_EXTENSION){
                        if (!imagepng ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                            throw new Exception('failed to save resized image');
                        }
                    }
                }
            } else {
                throw new Exception('failed Upload');
            }
        }

        if($request->file->getClientOriginalExtension() === File::TXT_FILE_EXTENSION){
            $request->file->storeAs('public/uploads', $name);
        }

        $url  = $request->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$name);
        return response()->json(['url' => $url, 'file' => basename($url)]);
    }


    /**
     * PIPHP_ImageResize
     *
     *
     * @param $image
     * @param $w
     * @param $h
     * @return false|resource
     */
    function PIPHP_ImageResize($image, $w, $h)
    {
        $oldw = imagesx($image);
        $oldh = imagesy($image);
        $temp = imagecreatetruecolor($w, $h);
        imagecopyresampled($temp, $image, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
        return $temp;
    }
}