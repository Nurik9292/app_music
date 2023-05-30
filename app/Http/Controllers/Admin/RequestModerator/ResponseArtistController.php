<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestArtist;

class ResponseTrackController extends Controller
{
    public function __invoke(RequestArtist $request)
    {
        $request->update(['response' => 'отказано']);

        return response([]);
    }
}
