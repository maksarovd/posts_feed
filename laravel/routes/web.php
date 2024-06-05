<?php

use App\Http\Controllers\{CommentController, ProfileController};
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetNestedLevelToComment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');

    Route::get('/comments/create/{comment?}', [CommentController::class, 'create'])->name('comments.create');

    Route::get('/comments/show/{comment}', [CommentController::class, 'show'])->name('comments.show');

    Route::get('/comments/edit/{comment}', [CommentController::class, 'edit'])->name('comments.edit');

    Route::delete('/comments/delete/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware(SetNestedLevelToComment::class);

    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::get('/comments/reloadCaptcha', [CommentController::class, 'reloadCaptcha'])->name('comments.reload_captcha');
});

require __DIR__.'/auth.php';
