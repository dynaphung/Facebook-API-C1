<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{

    //Send Friend Request
    public function sendRequest(Request $request)
    {
        $friendId = $request->friend_id;
        $user = auth()->user();

        // Check if a friend request already exists
        if ($user->friends()->where('friend_id', $friendId)->exists()) {
            return response()->json(['message' => 'Friend request already sent'], 400);
        }

        $user->friends()->attach($friendId, ['status' => 'pending']);

        return response()->json(['message' => 'Friend request sent']);
    }


    //Accept Friend Request
    public function acceptRequest($id)
    {
        $friend = User::findOrFail($id);
        $user = auth()->user();

        $friendRequest = $user->friendRequests()->where('user_id', $friend->id)->where('status', 'pending')->first();

        if (!$friendRequest) {
            return response()->json(['message' => 'Friend request not found'], 404);
        }

        $friendRequest->pivot->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted']);
    }


    //Reject Friend Request
    public function rejectRequest($id)
    {
        $friend = User::findOrFail($id);
        $user = auth()->user();

        $friendRequest = $user->friendRequests()->where('user_id', $friend->id)->where('status', 'pending')->first();

        if (!$friendRequest) {
            return response()->json(['message' => 'Friend request not found'], 404);
        }

        $user->friendRequests()->updateExistingPivot($friend->id, ['status' => 'rejected']);

        return response()->json(['message' => 'Friend request rejected']);
    }

    // View List of Friends
    public function viewFriends()
    {
        $user = Auth::user();
        $friends = Friend::where('friend_id', $user->id)->get();
        return response()->json(['status' => true, 'data' => $friends]);
    }
}
