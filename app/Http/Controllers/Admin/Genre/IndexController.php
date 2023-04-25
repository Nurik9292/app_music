<?php

namespace App\Http\Controllers\Admin\Genre;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('genre.index');
    }
}