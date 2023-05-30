<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use App\Models\Artist;
use App\Models\RequestArtist;

class ShowArtistRequestController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $artists = RequestArtist::all();

        foreach ($artists as $idx => $item) {
            if (count($artist = Artist::where('id', $item->artist_id)->get()) > 0) {
                $data['id'] = $artist[0]->id;
                $data['name'] = $artist[0]->name;
                $data['actions'] = $item->actions;
                $data['request'] = $item->id;
                $data['response'] = $item->response;
            }
        }

        if (count($data) == 0) return response([]);

        return new ArtistResource($data);
    }
}
