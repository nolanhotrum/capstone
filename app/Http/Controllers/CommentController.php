<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validate the request data
        $data = $request->validate([
            'body' => 'required',
        ]);

        // Find the location (park) by ID
        $location = Location::find($id);

        if (!$location) {
            return abort(404); // Handle location not found
        }

        // Create a new comment associated with the location and the currently authenticated user
        $comment = new Comment([
            'body' => $data['body'],
        ]);

        // Use the authenticated user's ID as the 'user_id'
        $comment->user_id = auth()->user()->id;

        // Associate the comment with the location by setting the 'park_id'
        $comment->park_id = $location->id;

        $comment->page_id = $location->id;

        $comment->created_at = now();
        $comment->updated_at = now();

        // Save the comment to the database
        $comment->save();

        return back()->with('success', 'Comment added successfully');
    }
}
