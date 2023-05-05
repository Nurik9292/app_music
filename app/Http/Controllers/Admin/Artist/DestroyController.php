<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Artist;

class DestroyController extends BaseController
{
    public function __invoke(Artist $artist)
    {

        // Storage::disk('public')->delete([$artist->artwork_url, $artist->thumb_url]);

        $path = $artist->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = '/home/nury/nfs/production/' . substr($path, strpos($path, "images"), strlen($path));

        $this->service->delete($path);

        $artist->delete();

        return redirect()->back();
    }
}