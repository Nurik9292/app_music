<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class DeleteTrackController extends Controller
{
    public function __invoke(Request $request, Playlist $playlist)
    {
        $playlist->tracks()->detach($request->all());

        return response([]);
    }
}
