<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Track;

class EditController extends Controller
{
    public function __invoke(Playlist $playlist)
    {
        $genres = Genre::orderByDesc('name_ru')->get();
        $tracks = Track::orderByDesc('title')->get();

        return view('playlist.edit', compact('playlist', 'genres', 'tracks'));
    }
}
