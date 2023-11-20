<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Rating;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'type_id',
        'address',
        'park_name',
        'community',
        'longitude',
        'latitude',
        'add_info'
    ];

    public function park()
    {
        return $this->hasOne(Park::class);
    }

    public function trail()
    {
        return $this->hasOne(Trail::class);
    }

    // Define the 'comments' relationship
    public function comments()
    {
        return $this->hasMany(Comment::class, 'page_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'park_id');
    }
}
