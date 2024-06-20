<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User as UserResource;
use App\Http\Resources\Api\File as FileResource;
use App\Models\{User, File};


class Comment extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'text'      => $this->text,
            'parent_id' => $this->parent_id,
            'user'      => new UserResource(User::findOrFail($this->user_id)),
            'file'      => new FileResource(File::where('comment_id', $this->id)->first()),
            'replyes'   => $this->childrenComments($this->id)
        ];
    }
}
