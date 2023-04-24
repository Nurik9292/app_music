<?php

namespace App\Http\Controllers\Admin\Track;

use App\Models\Track;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $tracks = Track::orderByDesc('created_at')->get();

        $this->service->statusChangetoString($tracks);

        return view('track.index', compact('tracks'));
    }
}