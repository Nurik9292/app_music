<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Track;
use OwenIt\Auditing\Models\Audit;

class ShowTrackController extends Controller
{
    public function __invoke()
    {
        $data = [];

        Audit::where('auditable_type', 'like', Track::class)->get();

        return new TrackResource($data);
    }
}
