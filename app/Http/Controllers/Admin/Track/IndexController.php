<?php

namespace App\Http\Controllers\Admin\Track;

use App\Models\RequestTrack;
use App\Models\Track;

class IndexController extends BaseController
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $auth = auth()->user()->role;

        $tracks = Track::orderBy('title')->paginate(10);

        $this->service->statusChangetoString($tracks);

        return view('track.index', compact('tracks', 'auth'));
    }
}
