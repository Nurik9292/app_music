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
                $data[$item->id]['id'] = $arist->id;
                $data[$item->id]['name'] = $arist->name;
                $data[$item->id]['actions'] = $item->actions;
                $data[$item->id]['request'] = $item->id;
                $data[$item->id]['response'] = $item->response;
                $data[$item->id]['what'] = $item->what;
                $data[$item->id]['data'] = unserialize($item->data);
            }
        }

        if (count($data) == 0) return response([]);

        return new ArtistResource($data);
    }
}