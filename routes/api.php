<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendShipController;
use App\Http\Controllers\PostController;
use App\Models\FriendRequest;
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

    Route::get('/list/post', [PostController::class, 'index']);

    Route::get('/show/post/{id}', [PostController::class, 'show']);

    Route::put('update/post/{id}', [PostController::class, 'update']);

    Route::delete('delete/post/{id}', [PostController::class, 'destroy']);
    
    Route::get('posts/users/{user_id}', [PostController::class, 'showPostsBy']);

    
    // Route::get('likes/posts/{post_id}', [LikeController::class, 'showLikesBy']);
});

// Route::middleware('auth:api')->prefix('friendShip')->group(function () {
//     Route::post('/request', [FriendShipController::class, 'sendRequest']);
//     Route::post('/accept/{id}', [FriendShipController::class, 'acceptRequest']);
//     Route::post('/decline/{id}', [FriendShipController::class, 'declineRequest']);
//     Route::delete('/delete/{user_id}/{user_request_id}', [FriendShipController::class, 'deleteFriend']);
// });
Route::post('send-friend-request', [FriendRequestController::class, 'sendRequest']);
Route::post('respond-to-request', [FriendRequestController::class, 'respondToRequest']);
Route::get('friends-list', [FriendShipController::class, 'friendsList']);
Route::delete('remove-friend/{id}', [FriendShipController::class, 'removeFriend']);