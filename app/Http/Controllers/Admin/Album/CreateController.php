<?php

namespace App\Http\Controllers\Admin\Album;

use App\Enums\AlbumTypes;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;

class CreateController extends Controller
{
    public function __invoke()
    {
        $album = new Album();
        $types = $album->getTypes();

        $artists = Artist::orderBy('name')->get();

        return view('album.create', compact('types', 'artists'));
    }
}