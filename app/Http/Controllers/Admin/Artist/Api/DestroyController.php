<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Models\Artist;

class DestroyController extends BaseController
{
    public function __invoke(Artist $artist)
    {
        $path = $artist->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artist_artWork\//', '', $path);

        $this->service->delete($path);

        $artist->albums()->detach();
        $artist->tracks()->detach();

        $artist->delete();

        return response([]);
    }
}
