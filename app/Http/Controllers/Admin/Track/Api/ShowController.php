<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Track;

class ShowController extends Controller
{
    public function __invoke(Track $track)
    {
        $album = $track->album ?? null;
        $artists = $track->artists ?? null;
        $genres = $track->genres ?? null;
        $status = $track->status;
        $artwork_url = $track->artwork_url;
        $audio_url = $track->audio_url;
        $track_number = $track->track_number;
        $title = $track->title;
        $is_national = $track->is_national;


        if (count($album) > 0)
            unset($album[0]['pivot']);

        for ($i = 0; $i < count($artists); $i++)
            unset($artists[$i]['pivot']);

        for ($i = 0; $i < count($genres); $i++)
            unset($genres[$i]['pivot']);



        return new TrackResource([
            'album' => $album,
            'track' => $track,
            'genres' => $genres,
            'status' => $status,
            'track_number' => $track_number,
            'artists' => $artists,
            'title' => $title,
            'artwork_url' => $artwork_url,
            'audio_url' => $audio_url,
            'is_national' => $is_national,
        ]);
    }
}
