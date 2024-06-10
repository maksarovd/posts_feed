<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class File extends Model
{
    protected $guarded = [];

    use HasFactory;


    const MEDIA_FILE_WIDTH   = 320;

    const MEDIA_FILE_HEIGHT  = 240;

    const UPLOAD_FILE_PATH   = 'uploads';

    const TXT_FILE_EXTENSION = 'txt';

    const GIF_FILE_EXTENSION = 'gif';

    const PNG_FILE_EXTENSION = 'png';

    const JPEG_FILE_EXTENSION = 'jpeg';

    const JPG_FILE_EXTENSION = 'jpg';


    /**
     * Comment
     *
     *
     * @access public
     * @return Relation
     */
    public function comment(): Relation
    {
        return $this->belongsTo(Comment::class);
    }


    /**
     * Has File
     *
     *
     * @access public static
     * @param Comment $comment
     * @return bool
     */
    public static function hasFile(Comment $comment)
    {
        if(!$comment->file){
            return false;
        }

        return Str::endsWith($comment->file->file_name, ['.txt']);
    }



    /**
     * Has Image
     *
     *
     * @access public static
     * @param $comment
     * @return bool
     */
    public static function hasImage($comment)
    {
        if(!$comment->file){
            return false;
        }

        return Str::endsWith($comment->file->file_name, ['.jpg','.jpeg','.gif','.png']);
    }

    /**
     * Get Url
     *
     *
     * @param $comment
     * @access public
     * @return string
     */
    public static function getUrl($comment)
    {
        return request()->schemeAndHttpHost() . Storage::url(File::UPLOAD_FILE_PATH.'/'.$comment->file->file_name);
    }
}
