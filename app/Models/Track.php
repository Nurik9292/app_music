<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public $timestamps = false;


    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_track', 'track_id', 'artist_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_track', 'track_id', 'genre_id');
    }

    public function album()
    {
        return $this->belongsToMany(Album::class, 'album_track', 'track_id', 'album_id');
    }
}