<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use App\Traits\RecursiveRenderer;


class Comment extends Model
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
     * Get Parent
     *
     *
     * @access public
     * @return Comment
     */
    public function getParent(): Comment
    {
        return Comment::where('id', $this->parent_id)->first();
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


    /**
     * Parent Comments
     *
     *
     * @access public static
     * @return LengthAwarePaginator
     */
    public static function parentComments(): LengthAwarePaginator
    {
        $sorting = request('sorting');

        return Comment::with('user')
            ->whereNull('parent_id')
            ->orderBy(
                User::select($sorting['sortBy'])->whereColumn('users.id','comments.user_id'), $sorting['orderBy']
            )
            ->paginate(25);
    }


    /**
     * Children Comments
     *
     *
     * @param $id
     * @access public
     * @return Collection
     */
    public function childrenComments($id): Collection
    {
        return Comment::with('replies')
            ->where('parent_id', $id)
            ->get();
    }



    /**
     * Answers
     *
     *
     * @access public
     * @return array
     */
    public function answers()
    {
        $collection = Comment::with('replies','file')
            ->where('id', $this->id)
            ->get();

        return $this->simplifyNesting($collection);
    }
}
