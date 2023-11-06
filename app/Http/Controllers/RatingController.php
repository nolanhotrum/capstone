<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function rate(Request $request, $id)
    {
        $ratingValue = $request->input('rating');

        // Validate and store the rating in the 'ratings' table
        $rating = new Rating([
            'rating_value' => $ratingValue,
            'user_id' => auth()->user()->id,
            'park_id' => $id,
        ]);
        $rating->save();

        return redirect()->back()->with('success', 'Thank you for rating this park!');
    }

    public function replace(Request $request, $id, $ratingId)
    {
        $ratingValue = $request->input('rating');

        $rating = Rating::find($ratingId);

        if (!$rating || $rating->user_id != auth()->user()->id || $rating->park_id != $id) {
            return abort(404); // Handle not found or unauthorized access
        }

        // Update the existing rating
        $rating->rating_value = $ratingValue;
        $rating->save();

        return redirect()->back()->with('success', 'Your rating has been updated.');
    }
}
