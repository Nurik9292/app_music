<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ArtistTrack extends Model implements Auditable
{
    use HasFactory;
    use Filterable;
    use AuditingAuditable;

    protected $connection = 'pgsql_prod';

    protected $guarded = false;

    public $timestamps = false;
}
