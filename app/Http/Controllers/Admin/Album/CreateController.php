<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('album.create');
    }
}