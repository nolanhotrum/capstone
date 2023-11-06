<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;

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
        return $this->belongsTo(Location::class, 'page_id');
    }
}
