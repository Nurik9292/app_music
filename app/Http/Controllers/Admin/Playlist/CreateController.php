<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Track;

class CreateController extends Controller
{
    public function __invoke()
    {
        $genres = Genre::orderByDesc('name_ru')->get();
        $tracks = Track::orderByDesc('title')->get();

        return view('playlist.create', compact('genres', 'tracks'));
    }
}
