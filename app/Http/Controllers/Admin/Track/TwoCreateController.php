<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;

class TwoCreateController extends Controller
{
    public function __invoke()
    {
        return view('track.two');
    }
}