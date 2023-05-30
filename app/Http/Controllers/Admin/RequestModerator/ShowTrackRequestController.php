<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\RequestTrack;
use App\Models\Track;

class ShowTrackRequestController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $tracks = RequestTrack::all();

        foreach ($tracks as $idx => $item) {
            if (count($track = Track::where('id', $item->track_id)->get()) > 0) {
                $data['id'] = $track[0]->id;
                $data['title'] = $track[0]->title;
                $data['actions'] = $item->actions;
                $data['request'] = $item->id;
                $data['response'] = $item->response;
            }
        }

        if (count($data) == 0) return response([]);

        return new TrackResource($data);
    }
}
