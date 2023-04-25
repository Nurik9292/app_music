<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Genre\Api\UpdateRequest;
use App\Http\Resources\Admin\GenreResource;
use App\Models\Genre;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Genre $genre)
    {
        $data = $request->validated();

        $genre->update($data);

        return new GenreResource($genre);
    }
}