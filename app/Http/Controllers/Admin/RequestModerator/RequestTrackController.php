<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestTrack;
use App\Models\Track;
use Illuminate\Http\Request;

class RequestTrackController extends Controller
{
    public function __invoke(Request $request, Track $track)
    {
        $data = $request->only('actions');
        $data['track_id'] = $track->id;
        $data['response'] = 'ожидает';

        RequestTrack::create($data);

        return response([]);
    }
}
