<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendation;

class AdminController extends Controller
{
    public function showParkRequests()
    {
        $user = auth()->user();

        if ($user && $user->role === 1) {
            // Fetch all recommendations
            $parkRequests = Recommendation::all();

            return view('admin', ['parkRequests' => $parkRequests]);
        } else {
            return redirect('/'); // Or you can redirect or show an error page
        }
    }
}
