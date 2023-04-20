<?php

namespace App\Services\Admin\Artist;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Service
{
    public function resize($data, $artist = null)
    {

        if (isset($artist))
            Storage::disk('public')->delete([$artist->artwork_url, $artist->thumb_url]);

        $image_name = $data['artwork_url']->getClientOriginalName();

        $artWork =  Image::make($data['artwork_url']);
        $thumb = clone $artWork;

        $path_artWork = "/app/public/images/artist/artWork/";
        $path_thumb = "/app/public/images/artist/thumb/";

        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);

        if (!file_exists(storage_path($path_artWork)))
            mkdir(storage_path($path_artWork), 0777, true);

        $artWork->fit(375, 250)->save(storage_path($path_artWork) . $image_name);
        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);

        $data['artwork_url'] = "images/artist/artWork/$image_name";
        $data['thumb_url'] = "images/artist/thumb/$image_name";

        return $data;
    }


    public function status($data)
    {
        if (isset($data['status'])) return true;

        return false;
    }


    public function dateFormate($artists)
    {
        $dates = [];

        foreach ($artists as $artist)
            $dates[$artist->id] = Carbon::parse($artist->created_at)->format('d-m-Y');

        return $dates;
    }

    public function statusChangetoString($artists)
    {
        foreach ($artists as $artist) {
            if ($artist->status) $artist['status'] = 'on';
            else $artist['status'] = 'off';
        }
    }
}