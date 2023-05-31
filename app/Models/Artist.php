<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Artist extends Model implements Auditable
{
    use HasFactory;
    use AuditingAuditable;


    protected $connection = 'pgsql_prod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio_tk',
        'bio_ru',
        'artwork_url',
        'thumb_url',
        'country_id',
        'status'
    ];

    public $timestamps = false;


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, "artist_album", "artist_id", "album_id");
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, "artist_track", "artist_id", "track_id");
    }
}
