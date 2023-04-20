<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Artist;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $artists = Artist::all();

        $this->service->statusChangetoString($artists);

        $dates = $this->service->dateFormate($artists);

        return view('artist.index', compact('artists', 'dates'));
    }
}