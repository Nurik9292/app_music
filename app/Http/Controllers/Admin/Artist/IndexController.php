<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('artist.index');
    }
}
