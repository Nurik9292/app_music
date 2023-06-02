<?php

namespace App\Http\Controllers\Admin\Genre;

use App\Http\Controllers\Controller;
use App\Models\Genre;

class IndexController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $auth = auth()->user()->id;

        $genres =  Genre::all();

        return view('genre.index', compact('genres', 'auth'));
    }
}
