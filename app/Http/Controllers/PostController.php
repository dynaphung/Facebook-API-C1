<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message'=> 'Get posts are successfully.', 'data'=> Post::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => request('title'),
            'description' => request('description'),
            'user_id' => request('user_id')
        ]);
        return response()->json(['message'=> 'Ceate post is successfully.', 'data'=> $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json(['message'=> 'Get post is successfully.', 'data'=> $post]);
        } else {
            return response()->json(['message'=> 'Post id does not exist.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showPostsBy($user_id)
    {
        $posts = User::find($user_id)->posts;
        return response()->json(['message'=> 'Get posts by user are successfully.', 'data'=> $posts]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update([
            'title' => request('title'),
            'description' => request('description'),
            'user_id' => $post->id
        ]);
        return response()->json(['message'=> 'Update post is successfully.', 'data'=> $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return response()->json(['message'=> 'Delete post is successfully.']);
        } else {
            return response()->json(['message'=> 'Post id does not exist.']);
        }
    }
}
