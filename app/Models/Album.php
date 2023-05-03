<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_prod';

    protected $guarded = false;

    public $timestamps = false;

    private const ALBUM = 1;
    private const SINGLE = 2;
    private const SOUNDTRACK = 3;
    private const LIVE = 4;
    private const REMIX = 5;


    public function getTypes()
    {
        return [
            self::ALBUM => 'album',
            self::SINGLE => 'single',
            self::SOUNDTRACK => 'soundtrack',
            self::LIVE => 'live',
            self::REMIX => 'remix',
        ];
    }


    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'album_track', 'album_id', 'track_id');
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_album', 'album_id', 'artist_id');
    }
}