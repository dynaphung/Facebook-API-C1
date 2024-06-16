<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => 'Get posts are successfully.', 'data' => Post::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addPost(Request $request)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth()->user()->id
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        $post = new PostResource($post);
        if ($post) {
            return response()->json(['message' => 'Get post is successfully.', 'data' => $post]);
        } else {
            return response()->json(['message' => 'Post id does not exist.']);
        }
    }


    public function showLikesBy($post_id)
    {
        // Eager load 'likes' and 'user' relationship
        $post = Post::with('likes.user')->find($post_id);

        // Check if post with the given ID exists
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        // Retrieve the likes associated with the post
        $likes = LikeResource::collection($post->likes);

        // Return response
        return response()->json(['message' => 'Likes retrieved successfully.', 'data' => $likes]);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            "title" => "required",
            "content" => "required",
        ]);
        $post = Post::find($id);

        if ($post) {
            $post->title = $request->title;
            $post->content = $request->content;
            $post->update();

            return response()->json(['message' => 'Update post is successfully.', 'data' => $post]);
        } else {
            return response()->json(['message' => 'Post id does not exist.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return response()->json(['message' => 'Delete post is successfully.']);
        } else {
            return response()->json(['message' => 'Post id does not exist.']);
        }
    }

    public function addLike(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
        ]);

        $liked = Like::where('post_id', $request->post_id)->where('user_id', Auth()->user()->id)->first();
        if ($liked) {
            $liked->delete();
            return response()->json(['message' => 'Unliked.']);
        }

        Like::create([
            'user_id' => Auth()->user()->id,
            'post_id' => $request->post_id,
        ]);
        return response()->json(['message' => 'Like post is successfully.']);
    }
}
