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
        if (auth()->user()->role !== 2)
            return redirect()->route('main');

        return view('block.overview.index');
    }
}