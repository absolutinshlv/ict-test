<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Middleware\CanDeleteComment;
use App\Http\Middleware\CanEditBlog;

Route::get('/', function () {
    return redirect()->route('blog.index');
});

Route::get('dashboard', function () {
    return redirect()->route('blog.index');
})->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::resource('blog', BlogController::class);

    Route::post('/blog/add-comment', [BlogController::class, 'addComment'])->name('blog.addComment');
    Route::delete('/blog/delete-comment/{comment}', [BlogController::class, 'deleteComment'])
        ->name('blog.deleteComment')
        ->middleware(CanDeleteComment::class);

    Route::middleware(CanEditBlog::class)->group(function () {
        Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });
});

require __DIR__ . '/auth.php';
