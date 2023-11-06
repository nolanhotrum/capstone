<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Comment;

class LocationController extends Controller
{
  public function insertDataFromJson()
  {
    $dogparks = [
      [
        "OBJECTID" => 1,
        "NAME" => "Hamilton SPCA",
        "ADDRESS" => "245 Dartnall Road",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "Upper part of park.",
        "LONGITUDE" => -79.83325,
        "LATITUDE" => 43.18456
      ],
      [
        "OBJECTID" => 2,
        "NAME" => "Heritage Green",
        "ADDRESS" => "447 1st Road West",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.77862,
        "LATITUDE" => 43.19607
      ],
      [
        "OBJECTID" => 3,
        "NAME" => "Hill Street Park",
        "ADDRESS" => "13 Hill Street",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.88951,
        "LATITUDE" => 43.25714
      ],
      [
        "OBJECTID" => 4,
        "NAME" => "Birch Avenue Leash Free Area",
        "ADDRESS" => "330 Wentworth Street",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.83917,
        "LATITUDE" => 43.26108
      ],
      [
        "OBJECTID" => 5,
        "NAME" => "Borer's Falls Dog Park",
        "ADDRESS" => "491 York Road",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.92682,
        "LATITUDE" => 43.28941
      ],
      [
        "OBJECTID" => 6,
        "NAME" => "Cathedral Park",
        "ADDRESS" => "707 King Street West",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.89166,
        "LATITUDE" => 43.26176
      ],
      [
        "OBJECTID" => 7,
        "NAME" => "Globe Leash Free Dog Park",
        "ADDRESS" => "Brampton Street",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.77085,
        "LATITUDE" => 43.24918
      ],
      [
        "OBJECTID" => 8,
        "NAME" => "Rail Trail Dog Park",
        "ADDRESS" => "Escarpment Rail Trail",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Fenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.86024,
        "LATITUDE" => 43.24753
      ],
      [
        "OBJECTID" => 9,
        "NAME" => "Chegwin Park",
        "ADDRESS" => "187 Chegwin Street",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Unfenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.95869,
        "LATITUDE" => 43.26327
      ],
      [
        "OBJECTID" => 10,
        "NAME" => "Corporal Nathan Cirillo Free Run Area",
        "ADDRESS" => "779 Golf Links Road",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Unfenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.95118,
        "LATITUDE" => 43.22812
      ],
      [
        "OBJECTID" => 11,
        "NAME" => "Strachan Street General Open Space",
        "ADDRESS" => "134 Strachan Street East",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Unfenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "",
        "LONGITUDE" => -79.85869,
        "LATITUDE" => 43.26535
      ],
      [
        "OBJECTID" => 12,
        "NAME" => "Hamilton SPCA",
        "ADDRESS" => "245 Dartnall Road",
        "COMMUNITY" => "Hamilton",
        "CATEGORY" => "Unfenced Dog Park",
        "WEBSITE" => "https=>//www.hamilton.ca/animals-pets/dogs/dog-parks",
        "COMMENTS" => "Lower part of park.",
        "LONGITUDE" => -79.83377,
        "LATITUDE" => 43.18364
      ]
    ];

    foreach ($dogparks as $park) {
      Location::create([
        'type_id' => 1, // Set the type_id as needed
        'address' => $park['ADDRESS'],
        'park_name' => $park['NAME'],
        'community' => $park['COMMUNITY'],
        'longitude' => $park['LONGITUDE'],
        'latitude' => $park['LATITUDE'],
        'add_info' => $park['COMMENTS'],
      ]);
    }

    return "Data from JSON file inserted into the 'locations' table.";
  }


  public function showMap()
  {
    $locations = Location::all(); // Retrieve all locations from the database
    return view('home', ['locations' => $locations, 'locationsJson' => $locations->toJson()]);
  }


  public function showLocation($id)
  {
    $location = Location::findOrFail($id);

    // You can also check for the type_id and determine what type it is.
    $type = ($location->type_id === 1) ? 'Park' : 'Trail';

    // You can pass the type to the view if needed.
    return view('show', compact('location', 'type'));
  }

  public function store(Request $request, $id)
  {
    $data = $request->validate([
      'body' => 'required',
    ]);

    // Find the park by ID
    $park = Location::find($id);

    if (!$park) {
      return abort(404); // Handle park not found
    }

    // Create a new comment associated with the park
    $comment = new Comment($data);
    $comment->page_id = $park->id; // Use 'page_id' as the foreign key
    $comment->save();

    return back()->with('success', 'Comment added successfully');
  }
}
