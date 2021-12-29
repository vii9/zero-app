<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipQueryEloquentController;

Route::get('/', function () {
    return view('hi');
});

Route::prefix('query')->group(function() {
    Route::get('posts/{role_name?}', [TipQueryEloquentController::class, 'getPostByUserHasRole'])
        ->name('posts.role');

    Route::get('post/{post_id}', [TipQueryEloquentController::class, 'getPostById'])
        ->name('posts.show');
});
