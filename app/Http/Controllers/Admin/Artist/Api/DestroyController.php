<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Models\Artist;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends BaseController
{
    public function __invoke(Artist $artist, User $user)
    {
        $path = $artist->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artist_artWork\//', '', $path);

        $this->service->delete($path);

        $artist->albums()->detach();
        $artist->tracks()->detach();

        $artist->delete();

        $audit =  Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}
