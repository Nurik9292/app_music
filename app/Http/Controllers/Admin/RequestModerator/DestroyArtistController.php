<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\RequestArtist;

class DestroyArtistController extends Controller
{
    public function __invoke(RequestArtist $request)
    {
        $request->delete();

        return response([]);
    }
}
