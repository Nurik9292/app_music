<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreAlbumController extends Controller
{
    public function __invoke(Request $request, Album $album)
    {
        $data = $request->all();

        foreach ($data['tracks'] as $track)
            $tracks[] = $track['id'];

        Log::debug($album);
        Log::debug($tracks);

        $album->tracks()->detach($tracks);
        $album->tracks()->attach($tracks);

        return response([]);
    }
}