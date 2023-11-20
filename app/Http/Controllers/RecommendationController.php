<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendation;

class RecommendationController extends Controller
{
    // Show the form to create a recommendation
    public function create()
    {
        return view('recommendation')->with('success', 'Recommendation submitted successfully. Wait for approval or denial.');
    }

    // Store a new recommendation in the database
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'park_name' => 'required|string|max:255',
            'type' => 'required|in:Park,Trail',
            'address' => 'required|string|max:255',
            'more_info' => 'nullable|string',
        ]);

        // Check if the user already has a pending recommendation
        $existingRecommendation = Recommendation::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existingRecommendation) {
            return redirect()->route('recommendation.create')
                ->with('error', 'You already have a pending recommendation. Wait for approval or denial.');
        }

        // Create and store the recommendation
        $recommendation = Recommendation::create([
            'user_id' => auth()->id(),
            'park_name' => $request->input('park_name'),
            'type' => $request->input('type'),
            'address' => $request->input('address'),
            'add_info' => $request->input('add_info'),
        ]);

        return redirect()->route('recommendation.create')
            ->with('success', 'Recommendation submitted successfully. Wait for approval or denial.');
    }
}
