<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Traits\{RecursiveRelation, RecursiveRenderer};

/**
 * Trait public methods:
 *
 *
 * @method  replies(): Relation
 * @method  renderReplies()
 */
class Comment extends Model
{
    use HasFactory, RecursiveRelation, RecursiveRenderer;


    protected $guarded = [];


    /**
     * Comments
     *
     *
     * @param $request
     * @return LengthAwarePaginator
     * @access public static
     */
    public static function comments($request): LengthAwarePaginator
    {
        return Comment::with('replies')
            ->whereNull('parent_id')
            ->orderBy($request->input('column', 'created_at'), $request->input('sortOrder',  'DESC'))
            ->paginate(25);
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

    public function getParentComment(Comment $comment)
    {
        return Comment::where('id', $comment->parent_id)->first();
    }

    public function getAuthorName(Comment $comment)
    {
        return User::where('id', $comment->user_id)->first();
    }


    /**
     * User
     *
     *
     * @return Relation
     * @access public
     */
    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
