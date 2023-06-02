<?php

namespace App\Http\Controllers\Admin\Block\Overview;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        if (auth()->user()->role !== 2 && auth()->user()->role !== 3)
            return redirect()->route('main');

        $auth = auth()->user();

        return view('block.overview.index', compact('auth'));
    }
}
