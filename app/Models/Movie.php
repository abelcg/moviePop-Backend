<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'img',
        'language',
        'genres',
        'release-date',
        'synopsis',
    ];

    /**
     * The users that belong to the movie.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'favorite_movies');
    }
}
