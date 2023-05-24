<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PlaylistResource;
use App\Models\Playlist;

class ShowController extends Controller
{
    public function __invoke(Playlist $playlist)
    {
        $tracks = $playlist->tracks;
        $genres = $playlist->genres;

        for ($i = 0; $i < count($tracks); $i++)
            unset($tracks[$i]['pivot']);

        for ($i = 0; $i < count($genres); $i++)
            unset($genres[$i]['pivot']);

        return new PlaylistResource([
            'title_tm' => $playlist->title_tm,
            'title_ru' => $playlist->title_ru,
            'status' => $playlist->status,
            'tracks' => $tracks,
            'genres' => $genres,
        ]);
    }
}
