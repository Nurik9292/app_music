<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestTrack;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestTrackController extends Controller
{
    public function __invoke(Request $request, Track $track)
    {
        $data = $request->all();

        if ($data['actions'] == 'update') {
            $actions = $data['actions'];

            if ($data['artwork_url'] != null)
                $data['artwork_url'] = Storage::disk('public')->put('images', $data['artwork_url']);

            foreach ($data as $key => $item) {
                $data['data'][$key] = $item;
                unset($data[$key]);
            }

            $data['data'] = serialize($data['data']);
            $data['actions'] = $actions;
        }

        $data['track_id'] = $track->id;
        $data['response'] = 'ожидает';

        if (count($requsetTrack = RequestTrack::where('track_id', $track->id)) > 0)
            $requsetTrack->update($data);
        else
            RequestTrack::create($data);

        return response([]);
    }
}
