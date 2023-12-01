<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'park_id',
    ];

    // Define the 'location' relationship
    public function location()
    {
        return $this->belongsTo(Location::class, 'park_id');
    }

    // Define the 'user' relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
