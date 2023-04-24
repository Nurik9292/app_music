<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Track;

class EditController extends Controller
{
    public function __invoke(Track $track)
    {
        $artists = Artist::orderByDesc('name')->get();

        return view('track.edit', compact('track', 'artists'));
    }
}