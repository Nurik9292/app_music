<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Artist;

class IndexController extends BaseController
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $auth = auth()->user()->role;

        $artists = Artist::all();

        $this->service->statusChangetoString($artists);

        $dates = $this->service->dateFormate($artists);

        return view('artist.index', compact('artists', 'dates', 'auth'));
    }
}