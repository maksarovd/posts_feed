<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Traits\RecursiveRenderer;
use Illuminate\Support\Carbon;


class Comment extends AbstractComment
{
    use HasFactory, RecursiveRenderer;


    protected $guarded = [];


    /**
     * User
     *
     *
     * @access public
     * @return Relation
     */
    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }



    /**
     * File
     *
     *
     * @access public
     * @return Relation
     */
    public function file(): Relation
    {
        return $this->hasOne(File::class);
    }



    /**
     * Replies
     *
     *
     * @access public
     * @return Relation
     */
    public function replies(): Relation
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with(['replies']);
    }


    /**
     * Get Date
     *
     *
     * @access public
     * @return string
     */
    public function getDate()
    {
        return Carbon::create($this->created_at)->toFormattedDateString();
    }


    /**
     * Get Nested
     *
     *
     * @param $push
     * @access public
     * @return string
     */
    public function getNested($push)
    {
        return $this->getAttribute('nested') * $push;
    }
}
