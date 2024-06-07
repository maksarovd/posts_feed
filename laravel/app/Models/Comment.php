<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        return Comment::hasMany(Comment::class, 'parent_id', 'id')->with(['replies']);
    }



    /**
     * Comments
     *
     *
     * @param $sorting
     * @return LengthAwarePaginator
     * @access public static
     */
    public static function comments($sorting): LengthAwarePaginator
    {
        switch ($sorting['sortBy']) {
            case 'name':
                return Comment::with('replies','user')
                    ->whereNull('parent_id')
                    ->orderBy(User::select('users.name')->whereColumn('users.id','comments.user_id'), $sorting['orderBy'])
                    ->paginate(25);
                break;
            case 'email':
                return Comment::with('replies','user')
                    ->whereNull('parent_id')
                    ->orderBy(User::select('users.email')->whereColumn('users.id','comments.user_id'), $sorting['orderBy'])
                    ->paginate(25);
                break;
            case 'created_at':
                return Comment::with('replies','user')
                    ->whereNull('parent_id')
                    ->orderBy(User::select('comments.created_at')->whereColumn('users.id','comments.user_id'), $sorting['orderBy'])
                    ->paginate(25);
                break;
        }
    }


    public function answers($id)
    {
        $collection = Comment::with('replies')
            ->where('id', $id)
            ->get();

        return $this->simplifyNesting($collection);
    }


    public function collection($id)
    {
        return Comment::with('replies')
            ->where('parent_id', $id)
            ->get();
    }


    public function getNestedFormatted($nested)
    {
        return $nested * 3;
    }


    public function getParent(Comment $comment)
    {
        return Comment::where('id', $comment->parent_id)->first();
    }


    public function getAuthor(Comment $comment)
    {
        return User::where('id', $comment->user_id)->first();
    }
}
