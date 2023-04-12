<?php

namespace App\Http\Controllers\Admin\Block\Radio;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        return view('block.radio.index');
    }
}