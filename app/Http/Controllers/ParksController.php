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
        $typeId = $request->input('type_id', 1); // Default type_id is set to 1

        $parks = Location::where('type_id', $typeId)
            ->when($filter === 'average_rating', function ($query) {
                $query->with('ratings')->orderByDesc(
                    Rating::selectRaw('COALESCE(AVG(rating_value), 0)')
                        ->whereColumn('park_id', 'locations.id') // Adjust here
                );
            })
            ->when($filter === 'most_comments', function ($query) {
                $query->withCount('comments')->orderByDesc('comments_count');
            })
            ->when(!in_array($filter, ['average_rating', 'most_comments']), function ($query) use ($typeId) {
                $query->where('type_id', $typeId);
            })
            ->get();

        return view('parks', compact('parks', 'filter', 'typeId'));
    }
}
