<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Track extends Model implements Auditable
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;
    use AuditingAuditable;

    protected $connection = 'pgsql_prod';

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