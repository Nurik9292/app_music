<?php

namespace App\Http\Controllers\Admin\Block\Listen;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        return view('block.listen.index');
    }
}