<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class StorePlaylistController extends Controller
{
    public function __invoke(Request $request, Playlist $playlist)
    {
        $data = $request->all();

        foreach ($data['tracks'] as $track)
            $tracks[] = $track['id'];

        $playlist->tracks()->detach($tracks);
        $playlist->tracks()->attach($tracks);

        return response([]);
    }
}