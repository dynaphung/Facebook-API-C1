<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => 'Get posts are successfully.', 'data' => Comment::all()]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'post_id' => 'required',
        ]);

        $comment = Comment::create([
            'description' => $request->description,
            'post_id' => $request->post_id,
            'user_id' =>Auth()->user()->id,
        ]);

        return response($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            "description" => "required",
        ]);

        $comment = Comment::find($id);
        if ($comment){
            $comment->update([
                "description" => $request->description,
            ]);
            return response()->json(['message' => 'Update comment is successfully.', 'data' => $comment]);
        }
        else{
            return response()->json(['message' => 'Comment id does not exist.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json(['message' => 'Delete comment is successfully.']);
        } else {
            return response()->json(['message' => 'Comment id does not exist.']);
        }
    }
}
