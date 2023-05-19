<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Artist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        Log::debug($data);

        $query = Artist::query();

        if (isset($data['artist'])) {
            $artist = $query->where('id', $data['artist'])->get();
            $tracks = $artist->tracks;
        } else {
            $tracks = Track::all();
        }
        $artists = Artist::all();

        return new TrackResource(['tracks' => $tracks, 'artists' => $artists]);
    }
}
