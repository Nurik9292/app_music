<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Track;

class EditController extends Controller
{
    public function __invoke(Track $track)
    {
        $artists = Artist::orderByDesc('name')->get();
        $albums = Album::orderByDesc('title')->get();
        $genres = Genre::orderByDesc('name_ru')->get();

        return view('track.edit', compact('track', 'artists', 'albums', 'genres'));
    }
}
