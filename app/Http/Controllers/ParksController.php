<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Rating;

class ParksController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $parks = Location::where('type_id', 1)
            ->when($filter === 'average_rating', function ($query) {
                $query->with('ratings')->orderByDesc(
                    Rating::selectRaw('COALESCE(AVG(rating_value), 0)')
                        ->whereColumn('park_id', 'locations.id') // Adjust here
                );
            })
            ->when($filter === 'most_comments', function ($query) {
                $query->withCount('comments')->orderByDesc('comments_count');
            })
            ->when($filter !== 'average_rating' && $filter !== 'most_comments', function ($query) {
                $query->where('type_id', 1);
            })
            ->get();

        return view('parks', compact('parks', 'filter'));
    }
}
