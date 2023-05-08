<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Artist;

class DestroyController extends BaseController
{
    public function __invoke(Artist $artist)
    {
        $path = $artist->artwork_url;
        $path = substr($path, 0, strpos($path, "artist_artWork/" . basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"), strlen($path));
        $path = preg_replace('/images\//', '', $path);

        $this->service->delete($path);

        $artist->albums()->detach();
        $artist->tracks()->detach();

        $artist->delete();

        return redirect()->back();
    }
}
