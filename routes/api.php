<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); 


Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/logout', [AuthController::class, 'logout']); 
    Route::post('/add/post', [PostController::class, 'addPost']);
    Route::get('/list/post', [PostController::class, 'index']);
    Route::get('/show/post/{id}', [PostController::class, 'show']);
    Route::put('update/post/{id}', [PostController::class, 'update']);
    Route::delete('delete/post/{id}', [PostController::class, 'destroy']);
    Route::get('posts/users/{user_id}', [PostController::class, 'showPostsBy']);
});

// Friend routes
Route::middleware('auth:sanctum')->prefix('friends')->group(function () {
    Route::post('/request', [FriendController::class, 'sendRequest']);
    Route::post('/accept/{id}', [FriendController::class, 'acceptRequest']);
    Route::post('/reject/{id}', [FriendController::class, 'rejectRequest']);
    Route::get('/list', [FriendController::class, 'viewFriends']);
});
