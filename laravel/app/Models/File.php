<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

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
     * @return Relation
     * @access public
     */
    public function comment(): Relation
    {
        return $this->belongsTo(Comment::class);
    }
}
