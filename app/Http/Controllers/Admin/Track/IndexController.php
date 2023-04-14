<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('track.index');
    }
}
