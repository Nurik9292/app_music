<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestTrack;

class DestroyTrackController extends Controller
{
    public function __invoke(RequestTrack $request)
    {
        $request->delete();

        return response([]);
    }
}
