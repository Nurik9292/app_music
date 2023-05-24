<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Album;

class ShowTrackController extends Controller
{
    public function __invoke(Album $album)
    {
        return new TrackResource($album->tracks);
    }
}
