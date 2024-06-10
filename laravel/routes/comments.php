<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\{SetNestedLevelToComment, SetSortingToRequest};


Route::middleware('auth')->group(function () {
    Route::controller(CommentController::class)->group(function(){
        Route::get('/comments', 'index')->name('comments.index')->middleware(SetSortingToRequest::class);
        Route::get('/comments/create/{comment?}', 'create')->name('comments.create');
        Route::get('/comments/show/{comment}',  'show')->name('comments.show');
        Route::get('/comments/edit/{comment}', 'edit')->name('comments.edit');
        Route::delete('/comments/delete/{comment}', 'destroy')->name('comments.destroy');
        Route::post('/comments', 'store')->name('comments.store')->middleware(SetNestedLevelToComment::class);
        Route::put('/comments/{comment}', 'update')->name('comments.update');

        Route::get('/comments/reloadCaptcha', 'reloadCaptcha')->name('comments.reload_captcha');
        Route::post('/comments/upload', 'upload')->name('comments.upload');
    });
});
