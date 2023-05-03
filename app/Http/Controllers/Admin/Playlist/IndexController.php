<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Models\Playlist;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $playlists = Playlist::orderByDesc('title_ru')->get();

        $this->service->statusChangetoString($playlists);

        $dates = $this->service->dateFormate($playlists);

        return view('playlist.index', compact('playlists', 'dates'));
    }
}