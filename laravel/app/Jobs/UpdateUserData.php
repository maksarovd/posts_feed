<?php

namespace App\Jobs;

use Illuminate\Bus\{Queueable};
use Illuminate\Foundation\Bus\{Dispatchable};
use Illuminate\Contracts\Queue\{ShouldQueue, ShouldBeUnique, ShouldBeUniqueUntilProcessing};
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\{Redis};
use App\Models\{Comment};


class UpdateUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(){}

    /**
     * Execute the job.
     * @param Comment $comment
     */
    public function handle(Comment $comment): void
    {
        Redis::throttle('key')->block(0)->allow(1)->every(10)->then(function () {
            info('Lock obtained...');
            $x = 2;
            // Handle job...
        }, function () {
            $x = 2;
            // Could not obtain lock...

            return $this->release(5);
        });
    }
}
