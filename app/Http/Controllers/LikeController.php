<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $like = Like::where('post_id', $validatedData['post_id'])
            ->where('user_id', $validatedData['user_id'])
            ->first();

        if ($like) {
            // User has already liked the post, so we'll delete the like
            $like->delete();
            return response()->json(['message' => 'Post unliked successfully.']);
        } else {
            // User has not liked the post yet, so we'll create a new like
            $like = Like::create($validatedData);
            return response()->json(['message' => 'Post liked successfully.']);
        }
    }

    public function destroy(string $id)
    {
        $like = Like::findOrFail($id);
        $like->delete();
        return response()->json(['message' => 'Post unliked successfully.']);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    // public function showLikesBy($post_id)
    // {
    //     $likes = Post::find($post_id)->likes;
    //     $users = $likes->map(function ($like) {
    //         return [
    //             'id' => $like->user_id,
    //             'name' => $like->getUser()->name, // Retrieve the user name using the getUser() method
    //         ];
    //     });

    //     return response()->json(['message' => 'Get likes by user are successfully.', 'data' => $users]);
    // }
}
