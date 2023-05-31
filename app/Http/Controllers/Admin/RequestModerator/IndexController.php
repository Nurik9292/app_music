<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestArtist;

class IndexController extends Controller
{
    public function __invoke()
    {
        // dd(RequestArtist::all());

        return view('moderator.index');
    }
}