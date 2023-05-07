<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;

class EditController extends Controller
{
    public function __invoke(Album $album)
    {
        $types = $album->getTypes();
        $artists = Artist::orderBy('name')->get();
        return view('album.edit', compact('album', 'types', 'artists'));
    }
}