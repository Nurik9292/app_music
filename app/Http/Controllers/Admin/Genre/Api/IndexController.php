<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\GenreResource;
use App\Models\Genre;

class IndexController extends Controller
{
    public function __invoke()
    {
        $genres = Genre::all();

        return GenreResource::collection($genres);
    }
}