<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;

class CreateController extends Controller
{
    public function __invoke()
    {
        $artists = Artist::orderByDesc('name')->get();
        $albums = Album::orderByDesc('title')->get();
        $genres = Genre::orderByDesc('name_ru')->get();

        return view('track.create', compact('artists', 'albums', 'genres'));
    }
}