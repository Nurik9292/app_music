<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlockResource;
use App\Models\Album;
use App\Models\BlockShema;
use App\Models\Playlist;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    public function __invoke(BlockShema $block)
    {
        $albums = [];
        $newPlaylists = [];
        $updatePlaylists = [];


        foreach ($block->blockAlbums as $al) {
            $albums[] = Album::where('id', $al->id)->get()[0];
        }

        foreach ($block->blockPlaylists as $pl) {
            $newPlaylists[] = Playlist::where('id', $pl->id)->get()[0];
        }

        foreach ($block->blockUpdatedPlaylists as $pl) {
            $updatePlaylists[] = Playlist::where('id', $pl->id)->get()[0];
        }

        return new BlockResource(['block' => $block, 'albums' => $albums, 'newPlaylists' => $newPlaylists, 'updatePlaylists' => $updatePlaylists]);
    }
}