<?php

namespace App\Http\Controllers\Admin\RequestModerator;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\RequestArtist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestArtistController extends Controller
{
    public function __invoke(Request $request, Artist $artist)
    {

        return response([]);
    }
}
