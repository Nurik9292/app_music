<?php

namespace App\Http\Controllers\Admin\Track;

use App\Models\Track;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $tracks = Track::orderBy('title')->paginate(10);

        $this->service->statusChangetoString($tracks);

        return view('track.index', compact('tracks'));
    }
}