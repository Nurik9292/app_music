<?php

namespace App\Http\Controllers\Admin\Album\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AlbumResource;
use App\Models\Album;
use Carbon\Carbon;

class ShowController extends Controller
{
    public function __invoke(Album $album)
    {
        $artists = $album->artists;

        for ($i = 0; $i < count($artists); $i++)
            unset($artists[$i]['pivot']);

        foreach ($album->getTypes() as $idx => $name)
            if ($album->type == $name)
                $type = ['id' => $idx, 'name' => $name];

        return new AlbumResource([
            'title' => $album->title,
            'description' => $album->description,
            'release_date' =>  Carbon::parse($album->release_date)->format('d/m/Y h:i:s'),
            'added_date' =>  Carbon::parse($album->added_date)->format('d/m/Y h:i:s'),
            'status' => $album->status,
            'is_national' => $album->is_national,
            'artists' => $artists,
            'type' => $type,
        ]);
    }
}
