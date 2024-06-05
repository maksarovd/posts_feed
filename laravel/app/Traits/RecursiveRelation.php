<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Comment;


trait RecursiveRelation
{


    /**
     * Replies
     *
     *
     * @access public
     * @return Relation
     */
    public function replies(): Relation
    {
        return Comment::hasMany(Comment::class, 'parent_id', 'id')
            ->with(['replies']);
    }

}