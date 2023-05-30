<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Artist;
use App\Models\RequestArtist;

class ShowArtistController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $artists = RequestArtist::all();

        foreach ($artists as $idx => $item) {
            if ($item->response != 'отказано' && $item->response != 'одобрено') {
                $arist = Artist::where('id', $item->artist_id)->get()[0];
                $data['id'] = $arist->id;
                $data['name'] = $arist->name;
                $data['actions'] = $item->actions;
                $data['request'] = $item->id;
                $data['response'] = $item->response;
                $data['data'] = unserialize($item->data);
            }
        }

        if (count($data) == 0) return response([]);

        return new ArtistResource($data);
    }
}
