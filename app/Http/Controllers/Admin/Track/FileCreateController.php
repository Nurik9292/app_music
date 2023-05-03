<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;

class FileCreateController extends Controller
{
    public function __invoke()
    {
        return view('track.files');
    }
}