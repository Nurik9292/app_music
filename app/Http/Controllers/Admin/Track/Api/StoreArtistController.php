<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class StoreArtistController extends Controller
{
    public function __invoke(Request $request, Artist $artist)
    {
        $data = $request->all();

        foreach ($data['tracks'] as $track)
            $tracks[] = $track['id'];

        $artist->tracks()->detach($tracks);
        $artist->tracks()->attach($tracks);

        return response([]);
    }
}
