<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;

class IndexController extends BaseController
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $albums = Album::orderBy('title')->get();

        $this->service->statusChangetoString($albums);

        [$added_dates, $release_dates] = array_values($this->service->dateFormateForIndex($albums));

        return view('album.index', compact('albums', 'added_dates', 'release_dates'));
    }
}
