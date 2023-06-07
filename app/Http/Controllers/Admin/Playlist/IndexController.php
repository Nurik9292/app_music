<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Models\Playlist;
use OwenIt\Auditing\Models\Audit;

class IndexController extends BaseController
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $auth = auth()->user();

        $playlists = Playlist::orderByDesc('title_ru')->get();

        $this->service->statusChangetoString($playlists);

        $dates = $this->service->dateFormate($playlists);

        return view('playlist.index', compact('playlists', 'dates', 'auth'));
    }
}