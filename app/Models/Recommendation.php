<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Recommendation extends Model
{
    protected $fillable = ['user_id', 'park_name', 'type', 'address', 'add_info', 'status', 'latitude', 'longitude'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
