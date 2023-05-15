<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlockResource;
use App\Models\BlockShema;

class ShowController extends Controller
{
    public function __invoke(BlockShema $block)
    {
        $body = json_decode($block->body);

        $albums = $body->albums ?? null;
        $playlists = $body->playlists ?? null;
        $tracks = $body->tracks ?? null;
        $genres = $body->genres ?? null;
        $name_status = $body->name_status;

        return new BlockResource([
            'block' => $block,
            'albums' => $albums,
            'playlists' => $playlists,
            'tracks' => $tracks,
            'genres' => $genres,
            'name_status' => $name_status
        ]);
    }
}