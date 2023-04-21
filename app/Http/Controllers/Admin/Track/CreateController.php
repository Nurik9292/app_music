<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class CreateController extends Controller
{
    public function __invoke()
    {
        $artists = Artist::all();

        return view('track.create', compact('artists'));
    }
}