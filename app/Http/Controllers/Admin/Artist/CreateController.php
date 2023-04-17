<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('artist.create');
    }
}
