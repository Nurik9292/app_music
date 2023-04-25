<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;
use App\Models\Album;

class EditController extends Controller
{
    public function __invoke(Album $album)
    {
        $types = $album->getTypes();

        return view('album.edit', compact('album', 'types'));
    }
}