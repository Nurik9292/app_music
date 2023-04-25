<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $albums = Album::orderByDesc('title')->get();

        $this->service->statusChangetoString($albums);

        [$added_dates, $release_dates] = array_values($this->service->dateFormateForIndex($albums));

        return view('album.index', compact('albums', 'added_dates', 'release_dates'));
    }
}