<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_prod';

    protected $table = 'playlist_tracks';

    protected $guarded = false;

    public $timestamps = false;
}
