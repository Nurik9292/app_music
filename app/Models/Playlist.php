<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $guarded = false;

    public $timestamps = false;

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track', 'playlist_id', 'track_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_playlist', 'playlist_id', 'genre_id');
    }
}