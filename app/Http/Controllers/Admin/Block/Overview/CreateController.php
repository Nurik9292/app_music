<?php

namespace App\Http\Controllers\Admin\Block\Overview;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class CreateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function __invoke()
    {
        $data = URL::previous();

        return view('block.overview.create', compact('data'));
    }
}