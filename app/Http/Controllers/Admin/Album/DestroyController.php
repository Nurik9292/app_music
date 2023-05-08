<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;

class DestroyController extends BaseController
{
    public function __invoke(Album $album)
    {
        // Storage::disk('public')->delete([$album->artwork_url, $album->thumb_url]);

        $path_artwork = $album->artwork_url;
        $path_artwork = substr($path_artwork, 0, strpos($path_artwork, basename($path_artwork)));
        $path_artwork = '/nfs/storage2/' . substr($path_artwork, strpos($path_artwork, "images"), strlen($path_artwork));

        $path_thumb = $album->thumb_url;
        $path_thumb = substr($path_thumb, 0, strpos($path_thumb, basename($path_thumb)));
        $path_thumb = '/nfs/storage2/' . substr($path_thumb, strpos($path_thumb, "images"), strlen($path_thumb));

        $this->service->delete($path_artwork);
        $this->service->delete($path_thumb);

        // $album->tracks()->detach();
        $album->artists()->detach();

        $album->delete();

        return redirect()->back();
    }
}
