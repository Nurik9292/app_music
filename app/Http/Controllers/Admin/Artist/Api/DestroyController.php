<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Admin\Artist\BaseController;
use App\Models\Artist;
use App\Models\ArtistAudit;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends BaseController
{
    public function __invoke(Artist $artist, User $user)
    {
        $tracks_id = null;
        $albums_id = null;
        $moderator = 3;


        $path = $artist->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artist_artWork\//', '', $path);

        $this->service->delete($path);

        $albums = $artist->albums;
        $artist->albums()->detach();
        $tracks = $artist->tracks;
        $artist->tracks()->detach();

        $artist->delete();

        $audit =  Audit::latest()->first();

        if ($user->role === $moderator) {
            foreach ($tracks as $track)
                $tracks_id[] = $track->id;

            foreach ($albums as $album)
                $albums_id[] = $album->id;

            ArtistAudit::create([
                'tracks' => json_encode($tracks_id),
                'albums' => json_encode($albums_id),
                'audit_id' => $audit->id,
            ]);
        }

        $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}
