<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Events\Dispatcher;
use App\Events\CommentAdd;


class CommentSubscriber
{


    public function handleCommentAdd(CommentAdd $event): void
    {
        //
    }

    public function subscribe(Dispatcher $events)
    {
        return [
            CommentAdd::class => 'handleCommentAdd'
        ];
    }
}
