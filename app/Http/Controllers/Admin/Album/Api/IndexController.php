<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Http\Resources\Admin\AlbumResource;
use App\Models\Album;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $albums = Album::all();

        [$added_dates, $release_dates] = array_values($this->service->dateFormateForIndex($albums));

        return new AlbumResource([
            'albums' => $albums,
            'added_dates' => $added_dates,
            'release_dates' => $release_dates,
        ]);
    }
}
