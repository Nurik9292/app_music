<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;

class DestroyController extends Controller
{
    public function __invoke(Genre $genre)
    {
        $genre->delete();

        return response([]);
    }
}