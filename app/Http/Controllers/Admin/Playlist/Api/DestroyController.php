<?php

namespace App\Http\Controllers\Admin\Playlist\Api;

use App\Http\Controllers\Admin\Playlist\BaseController;
use App\Models\Playlist;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends BaseController
{
    public function __invoke(Playlist $playlist, User $user)
    {
        if (($path = $playlist->thumb_url)) {
            $path = substr($path, 0, strpos($path,  basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $this->service->delete($path);
        }
        if (($path = $playlist->artwork_url) != '') {
            $path = substr($path, 0, strpos($path,  basename($path)));
            $path = pathToServer() . substr($path, strpos($path, "images"));
            $this->service->delete($path);
        }

        $playlist->tracks()->detach();
        $playlist->genres()->detach();

        $playlist->delete();

        $audit =  Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}