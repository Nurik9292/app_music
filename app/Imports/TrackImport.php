<?php

namespace App\Imports;

use App\Services\Admin\Artist\Service as ArtistService;
use App\Services\Admin\Track\Service as TrackService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrackImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $service_track = new TrackService;
        $service_artist = new ArtistService;

        foreach ($collection as $item)
            if (isset($item['artist']) && $item['artist'] != null) {
                $artist['name'] = $item['artist'];
                $artist['artwork_url'] = $item['artist_image_location'];
                $artist['status'] = 'on';

                $track['title'] = $item['track'];
                $track['artists'] = $item['artist'];
                $track['audio_url'] = $item['track_location'];
                $track['thumb_url'] = $item['track_image_location'];
                $track['is_national'] = 'on';

                $service_artist->store($artist);
                $service_track->store($track);
            }
    }
}