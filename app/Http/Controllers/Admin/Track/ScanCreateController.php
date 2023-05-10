<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;

class ScanCreateController extends Controller
{
    public function __invoke()
    {
        return view('track.scan');
    }
}
