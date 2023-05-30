<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestTrack;

class ResponseController extends Controller
{
    public function __invoke(RequestTrack $request)
    {

        $request->update(['response' => 'отказано']);

        return response([]);
    }
}
