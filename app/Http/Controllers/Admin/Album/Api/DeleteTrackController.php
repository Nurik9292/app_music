<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class DeleteTrackController extends Controller
{
    public function __invoke(Request $request, Album $album)
    {
        $album->tracks()->detach($request->all());

        return response([]);
    }
}
