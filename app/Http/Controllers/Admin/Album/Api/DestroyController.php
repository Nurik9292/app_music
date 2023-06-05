<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Admin\Album\BaseController;
use App\Models\Album;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends BaseController
{
    public function __invoke(Album $album, User $user)
    {
        $path = $album->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/album_artWork\//', '', $path);

        $this->service->delete($path);

        $album->tracks()->detach();
        $album->artists()->detach();

        $album->delete();

        $audit =  Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}