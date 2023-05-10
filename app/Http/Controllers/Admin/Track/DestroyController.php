<?php

namespace App\Http\Controllers\Admin\Track;

use App\Models\Track;

class DestroyController extends BaseController
{
    public function __invoke(Track $track)
    {
        $path = $track->thumb_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        // $path = preg_replace('/images\//', '', $path);

        $this->service->delete($path);

        $track->artists()->detach();
        $track->genres()->detach();
        $track->album()->detach();

        $track->delete();

        return redirect()->back();
    }
}