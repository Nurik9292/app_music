<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Http\Resources\Admin\PlaylistResource;
use App\Models\Playlist;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $playlists = Playlist::all();
        $genres = [];
        $added_dates = $this->service->dateFormate($playlists);

        foreach ($playlists as $playlist) {
            $genres[$playlist->id] = ['id' => $playlist->id];
            foreach ($playlist->genres as $genre) {
                $genres[$playlist->id]['name'] = [$genre->name_ru];
            }
        }


        return new PlaylistResource([
            'playlists' => $playlists,
            'genres' => $genres,
            "added_dates"  => $added_dates
        ]);
    }
}
