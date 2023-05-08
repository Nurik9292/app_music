<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;

class DestroyController extends BaseController
{
    public function __invoke(Album $album)
    {
        $path = $album->artwork_url;
        $path =  pathToServer() . substr($path,  strpos($path, 'images'));
        $path = substr($path, 0, strpos($path, "album_artWork/" . basename($path)));
        $path = preg_replace('/images\//', '', $path);

        $this->service->delete($path);

        // $album->tracks()->detach();
        $album->artists()->detach();

        $album->delete();

        return redirect()->back();
    }
}
