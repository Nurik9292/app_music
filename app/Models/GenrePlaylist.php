<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenrePlaylist extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_prod';

    protected $guarded = false;

    public $timestamps = false;
}