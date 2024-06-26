<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Contracts\View\View;
use App\Models\{Comment, File};
use App\Http\Requests\{ValidateUploadRequest, ValidateRequest};
use App\Services\{SortService, UploadImageService};
use Illuminate\Support\Facades\{Storage, Session, Cache, Auth, Process, DB};
use App\Events\CommentAdd;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;


class CommentController extends Controller
{

    /**
     * Index
     *
     *
     * @access public
     * @param $language
     * @param SortService $sorter
     * @return View
     */
    public function index($language, SortService $sorter)#: View
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
     * @param $language
     * @param Comment|null $comment
     * @return View
     */
    public function create($language, Comment $comment = null): View
    {
        return view('comments.create', ['comment' => $comment]);
    }


    /**
     * Show
     *
     *
     * @access public
     * @param $language
     * @param Comment $comment
     * @return View
     */
    public function show($language, Comment $comment): View
    {
        confirmDelete(__('Delete Comment?'), '');
        return view('comments.show', ['comment' => $comment]);
    }


    /**
     * Edit
     *
     *
     * @access public
     * @param $language
     * @param Comment $comment
     * @return View
     */
    public function edit($language, Comment $comment): View
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

            DB::transaction(function() use ($request){
                (new Comment)->fill($request->only(['captcha', 'text','parent_id','user_id']))->save();


                if($request->file_input){
                    $file = [
                        'comment_id' => Comment::latest()->first()->id,
                        'file_name'  => $request->file_input
                    ];

                    File::create($file);
                }

                CommentAdd::dispatch();
            });

            DB::commit();
            Alert::success('Success Title', __('Saving Success!'));
        }catch(\Throwable $exception){
            DB::rollBack();
            Alert::error('Error Title', __('Error when saving Comment ') .  $exception->getMessage());
        }


        return redirect()->route('comments.index',request('language','en'));

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

        DB::transaction(function() use ($request, $comment){
            try{
                $comment->fill($request->except(['file_input', 'file']))->save();

                if($request->file_input){
                    $file = [
                        'file_name'  => $request->file_input
                    ];

                    File::find($comment->file->id)->fill($file)->save();
                }

                DB::commit();
                Alert::success('Success Title', __('Updating Success!'));
            }catch(\Throwable $exception){
                DB::rollBack();
                Alert::error('Error Title', __('Error when updating Comment ') .  $exception->getMessage());

            }
        });


        return redirect()->route('comments.show', ['language' => request('language'),'comment' => $comment]);

    }


    /**
     * Destroy
     *
     *
     * @access public
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        try{
            DB::transaction(function() use($comment){
                $comment->delete();
                File::find($comment->file->id)->delete();
            });

            DB::commit();
            Alert::info('Info Title', __('Deleting Success!'));
        }catch(\Throwable $exception){
            DB::rollBack();
            Alert::error('Error Title', __('Error when deleting Comment ') .  $exception->getMessage());
        }


        return redirect()->route('comments.index',request('language'));

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
     * @throws Exception
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
