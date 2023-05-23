<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use App\Models\Artist;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $artists = Artist::all();

        return new ArtistResource($artists);
    }
}