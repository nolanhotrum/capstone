<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showParkRequests()
    {
        $user = auth()->user();

        if ($user && $user->role === 1) {
            return view('admin');
        } else {
            abort(403); // Or you can redirect or show an error page
        }
    }
}
