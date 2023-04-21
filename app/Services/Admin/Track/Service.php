<?php

namespace App\Services\Admin\Track;

use Owenoj\LaravelGetId3\GetId3;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Service
{
    public function track($data)
    {
        $track = new GetId3($data['audio_url']);

        $data['duration'] = $track->getPlaytime();
        $data['bit_rate'] = $track->extractInfo()['bitrate'];

        if ($data['track_number'])
            $data['track_number'] = $track->getTrackNumber();


        if ($track->getArtwork(true))
            $data['thumb_url'] = Storage::disk('public')->put('images/track', $track->getArtwork(true));
        else $data['thumb_url'] = $this->resize($data['thumb_url']);

        dd($data);
    }


    public function resize($data)
    {
        $image_name = $data->getClientOriginalName();

        $thumb =  Image::make($data);

        $path_thumb = "/app/public/images/track/";

        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);

        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);

        $data['thumb_url'] = "images/artist/thumb/$image_name";

        return $data;
    }
}