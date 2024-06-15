<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function sendRequest(Request $request)
    {
        // Validate input
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id|different:sender_id',
        ]);

        // Create a new friend request
        $friendRequest = FriendRequest::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
        ]);

        return response()->json(['message' => 'Friend request sent successfully'], 201);
    }

    public function respondToRequest(Request $request)
    {
        // Validate input
        $request->validate([
            'request_id' => 'required|exists:friend_requests,id',
            'accept' => 'required|boolean',
        ]);

        // Find the friend request
        $friendRequest = FriendRequest::findOrFail($request->request_id);

        // Update the friend request
        $friendRequest->update([
            'accepted' => $request->accept,
        ]);

        return response()->json(['message' => 'Friend request responded successfully'], 200);
    }
}
