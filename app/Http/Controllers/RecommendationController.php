<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Models\Location;
use GuzzleHttp\Client;

class RecommendationController extends Controller
{
    // Show the form to create a recommendation
    public function create()
    {
        return view('recommendation')->with('success', 'Recommendation submitted successfully. Wait for approval or denial.');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'park_name' => 'required|string|max:255',
            'type' => 'required|in:Park,Trail',
            'address' => 'required|string|max:255',
            'add_info' => 'nullable|string',
        ]);

        try {
            // Check if the user already has a pending recommendation
            $existingRecommendation = Recommendation::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->first();

            if ($existingRecommendation) {
                return redirect()->route('recommendation.create')
                    ->with('error', 'You already have a pending recommendation. Wait for approval or denial.');
            }

            // Geocode the address to get latitude and longitude
            $geoData = $this->geocodeAddress($request->input('address'));

            // Check if geocoding was successful before storing latitude and longitude
            if ($geoData && isset($geoData['lat']) && isset($geoData['lng'])) {
                // Create and store the recommendation
                $recommendation = Recommendation::create([
                    'user_id' => auth()->id(),
                    'park_name' => $request->input('park_name'),
                    'type' => $request->input('type'),
                    'address' => $request->input('address'),
                    'add_info' => $request->input('add_info'),
                    'latitude' => $geoData['lat'],
                    'longitude' => $geoData['lng'],
                ]);
            } else {
                // Handle the case where geocoding failed or the keys are missing
                return redirect()->route('recommendation.create')
                    ->with('error', 'Invalid address. Please enter a valid address.');
            }

            return redirect()->route('recommendation.create')
                ->with('success', 'Recommendation submitted successfully. Wait for approval or denial.');
        } catch (\Exception $e) {
            return redirect()->route('recommendation.create')
                ->with('error', 'An error occurred during recommendation submission. Please try again.');
        }
    }

    // Geocode an address using the Google Maps Geocoding API
    private function geocodeAddress($address)
    {
        $apiKey = 'AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw'; // Update with your API key

        $client = new Client();

        $addressWithOntario = $address . ', Ontario, Canada';

        try {
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $addressWithOntario,
                    'key' => $apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['results'][0]['geometry']['location'])) {
                return $data['results'][0]['geometry']['location'];
            } else {
                return null; // Return null instead of using dd
            }
        } catch (\Exception $e) {
            return null; // Return null instead of using dd
        }
    }


    public function approveDeny($id, $action)
    {
        $recommendation = Recommendation::findOrFail($id);

        if ($action === 'approve') {
            $this->approveRecommendation($recommendation);
        } elseif ($action === 'deny') {
            $this->denyRecommendation($recommendation);
        }

        return redirect()->route('admin');
    }

    private function approveRecommendation(Recommendation $recommendation)
    {
        // Map the string type to the corresponding integer value
        $typeMapping = [
            'Park' => 1,
            'Trail' => 2,
        ];

        $recommendation->update(['status' => 'approved']);

        // Add the recommendation to the locations table
        Location::create([
            'type_id' => $typeMapping[$recommendation->type],
            'park_name' => $recommendation->park_name,
            'address' => $recommendation->address,
            'add_info' => $recommendation->add_info,
            'latitude' => $recommendation->latitude,
            'longitude' => $recommendation->longitude,
            'community' => 'Hamilton',
        ]);
    }
    private function denyRecommendation(Recommendation $recommendation)
    {
        $recommendation->update(['status' => 'denied']);
    }
}
