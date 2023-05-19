<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\TrackFilter;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Artist;
use App\Models\Track;

class FilterController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $query = Artist::query();

        if (isset($data['artist'])) {
            $artist = $query->where('id', $data['artist'])->get();
            $tracks = $artist[0]->tracks;
        } else {
            $tracks = Track::all();
        }
        $artists = Artist::all();

        return new TrackResource(['tracks' => $tracks, 'artists' => $artists]);
    }
}
