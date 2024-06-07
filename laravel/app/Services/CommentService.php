<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\{Carbon, Facades\Storage, Str};
use Illuminate\Http\Request;


class CommentService
{

    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function cutText($text, $length = 20)
    {
        return Str::limit(strip_tags($text), $length);
    }


    public function getTransformDate($date)
    {
        return Carbon::create($date)->toFormattedDateString();
    }


    public function isSelected($sortBy, $orderBy)
    {
        $selected = '';

        if($this->request->get('sortBy') === $sortBy){
            if($this->request->get('orderBy') === $orderBy){
                $selected = 'selected';
            }
        }

        return $selected;
    }

    public function hasImage($comment)
    {
        if(!$comment->file){
            return false;
        }

        if(
            str_contains($comment->file->file_name, '.jpg') ||
            str_contains($comment->file->file_name, '.jpeg') ||
            str_contains($comment->file->file_name, '.gif') ||
            str_contains($comment->file->file_name, '.png')
        ){
            return true;
        }
        return false;
    }

    public function hasFile($comment)
    {
        if(!$comment->file){
            return false;
        }

        if(
            str_contains($comment->file->file_name, '.txt')
        ){
            return true;
        }
        return false;
    }

    public function getUrl($comment)
    {
        return $this->request->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$comment->file->file_name);
    }

}