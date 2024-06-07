<?php

namespace App\Services;

use App\Models\Comment;
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



    /**
     * Cut Text
     *
     *
     * @param $text
     * @param int $length
     * @access public
     * @return string
     */
    public function cutText($text, $length = 20)
    {
        return Str::limit(strip_tags($text), $length);
    }



    /**
     * Get Transform Date
     *
     *
     * @param $date
     * @access public
     * @return string
     */
    public function getTransformDate($date)
    {
        return Carbon::create($date)->toFormattedDateString();
    }



    /**
     * Is Selected
     *
     *
     * @param $sortBy
     * @param $orderBy
     * @access public
     * @return string
     */
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



    /**
     * Has Image
     *
     *
     * @param $comment
     * @access public
     * @return bool
     */
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



    /**
     * Has File
     *
     *
     * @param $comment
     * @access public
     * @return bool
     */
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



    /**
     * Get Url
     *
     *
     * @param $comment
     * @access public
     * @return string
     */
    public function getUrl($comment)
    {
        return $this->request->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$comment->file->file_name);
    }



    /**
     * Get Nested Formatted
     *
     *
     * @param $nested
     * @access public
     * @return string
     */
    public function getNestedFormatted($nested)
    {
        return $nested * 3;
    }



    /**
     * Get Parent
     *
     *
     * @param Comment $comment
     * @access public
     * @return Comment
     */
    public function getParent(Comment $comment): Comment
    {
        return Comment::where('id', $comment->parent_id)->first();
    }

}