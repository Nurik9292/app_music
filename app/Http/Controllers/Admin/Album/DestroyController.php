<?php

namespace App\Http\Controllers\Admin\Album;

use App\Models\Album;

class DestroyController extends BaseController
{
    public function __invoke(Album $album)
    {
        // Storage::disk('public')->delete([$album->artwork_url, $album->thumb_url]);

        $path = $album->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = '/home/nury/nfs/production/' . substr($path, strpos($path, "images"), strlen($path));

        $this->service->delete($path);


        // $album->tracks()->detach();
        $album->artists()->detach();

        $album->delete();

        return redirect()->back();
    }
}