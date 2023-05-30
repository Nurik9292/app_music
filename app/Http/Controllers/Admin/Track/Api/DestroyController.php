<?php

namespace App\Http\Controllers\Admin\Track\Api;

use App\Http\Controllers\Admin\Track\BaseController;
use App\Models\RequestTrack;
use App\Models\Track;

class DestroyController extends BaseController
{
    public function __invoke(Track $track)
    {
        if (($request = RequestTrack::where('id', $track->id)->get()) > 0)
            $request->update(['response' => 'одобрено']);

        $path = $track->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artwork\//', '', $path);

        $this->service->delete($path);

        $track->artists()->detach();
        $track->genres()->detach();
        $track->album()->detach();

        $track->delete();

        return response([]);
    }
}
