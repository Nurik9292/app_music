<?php

namespace App\Services\Admin\Artist;

use App\Models\Artist;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Service
{

    public function store($data)
    {
        $data = $this->resize($data);

        $data['status'] = $this->status($data);

        Artist::create($data);
    }

    public function update($data, $artist)
    {
        if ($data['artwork_url'])
            $data = $this->resize($data, $artist);

        $artist->update($data);
    }


    public function resize($data, $artist = null)
    {
        $country = Country::where("id", $data['country_id'])->get();
        $country = $country[0]->name;

        if (isset($artist))
            Storage::disk('public')->delete([$artist->artwork_url, $artist->thumb_url]);

        $image_name = $data['artwork_url']->getClientOriginalName();

        if (str_ends_with($image_name, "png"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "png") - 1);
        if (str_ends_with($image_name, "jpg"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpg") - 1);
        if (str_ends_with($image_name, "jpeg"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpeg") - 1);

        $artWork =  Image::make($data['artwork_url']);
        $artWork_webp =  Image::make($data['artwork_url']);

        $thumb = Image::make($data['artwork_url']);
        $thumb_webp = Image::make($data['artwork_url']);

        if ($country == 'Туркмения') {
            $path_artWork = "/app/public/tm_tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "/app/public/tm_tracks/{$data['name']}/artist_thumb/";
        } else {
            $path_artWork = "/app/public/tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "/app/public/tracks/{$data['name']}/artist_thumb/";
        }


        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);

        if (!file_exists(storage_path($path_artWork)))
            mkdir(storage_path($path_artWork), 0777, true);

        $artWork->fit(375, 250)->save(storage_path($path_artWork) . $image_name);
        $artWork_webp->fit(375, 250)->save(storage_path($path_artWork) . $image_name_wepb . ".webp");

        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);
        $thumb_webp->fit(142, 166)->save(storage_path($path_thumb) . $image_name_wepb . ".webp");

        if ($country == 'Туркменния') {
            $data['artwork_url'] = "tm_tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = "tm_tracks/{$data['name']}/artist_artWork/$image_name";
        } else {
            $data['artwork_url'] = "tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = "tracks/{$data['name']}/artist_thumb/$image_name";
        }

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