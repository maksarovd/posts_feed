<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\{ServiceProvider, Facades, Collection};
use App\Jobs\UpdateUserData;
use App\Models\Comment;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        $this->app->bindMethod([UpdateUserData::class, 'handle'], function(UpdateUserData $job,Application $app){
            $job->handle($app->make(Comment::class));
        });
    }
}
