<?php

namespace App\Http\Controllers\Admin\Genre;

use App\Http\Controllers\Controller;
use App\Models\Genre;

class IndexController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2)
            return redirect()->route('main');

        $genres =  Genre::all();

        return view('genre.index', compact('genres'));
    }
}