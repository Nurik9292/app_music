<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\RequestTrack;
use App\Models\Track;

class ShowRequestController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $tracks = RequestTrack::all();

        foreach ($tracks as $idx => $item) {
            $track = Track::where('id', $item->track_id)->get()[0];
            $data['id'] = $track->id;
            $data['title'] = $track->title;
            $data['actions'] = $item->actions;
            $data['request'] = $item->id;
            $data['response'] = $item->response;
        }

        if (count($data) == 0) return response([]);

        return new TrackResource($data);
    }
}
