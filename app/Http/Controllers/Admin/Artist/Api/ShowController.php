<?php

namespace App\Http\Controllers\Admin\Artist\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArtistResource;
use App\Models\Artist;

class ShowController extends Controller
{
    public function __invoke(Artist $artist)
    {
        $country = $artist->country;

        return new ArtistResource([
            'name' => $artist->name,
            'bio_tk' => $artist->bio_tk,
            'bio_ru' => $artist->bio_ru,
            'status' => $artist->status,
            'artwork_url' => $artist->artwork_url,
            'country' => $country,
        ]);
    }
}
