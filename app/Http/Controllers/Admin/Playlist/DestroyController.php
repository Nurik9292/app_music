<?php

namespace App\Http\Controllers\Admin\Playlist;

use App\Models\Playlist;

class DestroyController extends BaseController
{
    public function __invoke(Playlist $playlist)
    {
        $path = $playlist->thumb_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"), strlen($path));
        $path = preg_replace('/images\//', '', $path);

        $this->service->delete($path);
        $playlist->tracks()->detach();
        $playlist->genres()->detach();

        $playlist->delete();

        return redirect()->back();
    }
}
