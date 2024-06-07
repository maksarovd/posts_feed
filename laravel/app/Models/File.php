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
