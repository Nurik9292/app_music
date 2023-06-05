<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class RequestTrackController extends Controller
{
    public function __invoke(Request $request, Track $track)
    {

        return response([]);
    }
}
