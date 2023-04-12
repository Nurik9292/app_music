<?php

namespace App\Http\Controllers\Admin\Block\Overview;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function __invoke()
    {
        return view('block.overview.create');
    }
}