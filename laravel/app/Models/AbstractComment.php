<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AbstractComment extends Model
{
    use HasFactory;


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
