<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockShema extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_prod';

    protected $guarded = false;

    protected $table = 'block_shema';

    public $timestamps = false;

    public function blockNames()
    {
        return $this->belongsToMany(BlockName::class, 'block_names_block_shema', 'block_shema_id', 'block_name_id');
    }

    public function blockAlbums()
    {
        return $this->belongsToMany(Album::class, 'album_block_shema', 'block_shema_id', 'album_id');
    }

    public function blockPlaylists()
    {
        return $this->belongsToMany(Playlist::class, 'block_shema_playlists', 'block_shema_id', 'playlist_id');
    }

    public function blockUpdatedPlaylists()
    {
        return $this->belongsToMany(Playlist::class, 'block_shema_updated_playlists', 'block_shema_id', 'playlist_id');
    }
}