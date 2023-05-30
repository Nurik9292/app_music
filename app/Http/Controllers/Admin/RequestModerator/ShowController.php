<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\RequestTrack;
use App\Models\Track;

class ShowController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $tracks = RequestTrack::all();

        foreach ($tracks as $idx => $item) {
            if ($item->response != 'отказано' && $item->response != 'одобрено') {
                $track = Track::where('id', $item->track_id)->get()[0];
                $data['id'] = $track->id;
                $data['title'] = $track->title;
                $data['actions'] = $item->actions;
                $data['request'] = $item->id;
                $data['response'] = $item->response;
                $data['data'] = unserialize($item->data);
            }
        }

        if (count($data) == 0) return response([]);

        return new TrackResource($data);
    }
}
