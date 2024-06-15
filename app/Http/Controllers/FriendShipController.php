<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Http\Resources\FriendResource;
use App\Models\FriendShip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendShipController extends Controller
{

    public function friendsList()
    {
        $user = auth()->user(); // Assuming authentication is required

        // Retrieve the authenticated user's friends
        $friends = $user->friends;

        return response()->json($friends, 200);
    }

    public function removeFriend($id)
    {
        $user = auth()->user(); // Assuming authentication is required

        // Find the friend to remove
        $friend = User::findOrFail($id);

        // Detach the friend from the authenticated user
        $user->friends()->detach($friend);

        return response()->json(['message' => 'Friend removed successfully'], 200);
    }
        
    
}
