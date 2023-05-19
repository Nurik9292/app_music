<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistTrack extends Model
{
    use HasFactory;
    use Filterable;

    protected $connection = 'pgsql_prod';

    protected $guarded = false;

    public $timestamps = false;
}
