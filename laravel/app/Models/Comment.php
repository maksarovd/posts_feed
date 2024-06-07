<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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
     * @access public static
     * @return LengthAwarePaginator
     */
    public static function comments($sorting): LengthAwarePaginator
    {
        switch ($sorting['sortBy']) {
            case 'name':
                $sorting['sortBy'] = 'users.name';
                break;
            case 'email':
                $sorting['sortBy'] = 'users.email';
                break;
            case 'created_at':
                $sorting['sortBy'] = 'comments.created_at';
                break;
        }

        return Comment::with('user')
            ->whereNull('parent_id')
            ->orderBy(
                User::select($sorting['sortBy'])->whereColumn('users.id','comments.user_id'), $sorting['orderBy']
            )
            ->paginate(25);
    }


    /**
     * Answers
     *
     *
     * @param $id
     * @access public
     * @return array
     */
    public function answers($id)
    {
        $collection = Comment::with('replies')
            ->where('id', $id)
            ->get();

        return $this->simplifyNesting($collection);
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
}
