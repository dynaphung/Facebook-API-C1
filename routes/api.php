<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']); 

    // Route::resource('posts', PostController::class);

    Route::post('/add/post', [PostController::class, 'addPost']);

    Route::get('/get/post', [PostController::class, 'index']);

    Route::get('/show/post/{id}', [PostController::class, 'show']);

    Route::put('update/post/{id}', [PostController::class, 'update']);

    Route::delete('delete/post/{id}', [PostController::class, 'destroy']);
    
    Route::get('posts/users/{user_id}', [PostController::class, 'showPostsBy']);

    
    //================================== Comment =========================================
    Route::post('/add/comment', [CommentController::class, 'store']);
    Route::get('/get/comment', [CommentController::class, 'index']);
    Route::put('/update/comment/{id}', [CommentController::class, 'update']);
    Route::delete('/delete/comment/{id}', [CommentController::class, 'destroy']);

    Route::get('likes/posts/{post_id}', [LikeController::class, 'showLikesBy']);


    Route::post('/add/like', [PostController::class, 'addLike']);
});
