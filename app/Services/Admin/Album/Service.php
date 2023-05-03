<?php

namespace App\Services\Admin\Album;

use App\Models\Album;
use App\Models\Artist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Service
{

    public function store($data)
    {
        $data = $this->type($data);

        $data = $this->resize($data);

        $data['status'] = $this->status($data);

        $data = $this->dateFormat($data);

        $artists = $data['artists'];
        unset($data['artists']);

        $album = Album::create($data);

        $album->artists()->attach($artists);
    }


    public function update($data, $album)
    {
        if (isset($data['artwokr_url']))
            $data = $this->resize($data);

        if (isset($data['added_date']) || isset($data['release_date']))
            $data = $this->dateFormat($data);

        $data['status'] = $this->status($data);

        $data = $this->type($data);

        $artists = $data['artists'];
        unset($data['artists']);

        $album->update($data);

        $album->artists()->sync($artists);
    }


    private function resize($data, $album = null)
    {
        $arist = Artist::where('id', $data['artists'][0])->get();

        $arist_name = $arist[0]->name;

        if (isset($album))
            Storage::disk('public')->delete([$album->artwork_url, $album->thumb_url]);

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

        if (isset($data['is_national'])) {
            $path_artWork = "/app/public/tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/";
            $path_thumb = "/app/public/tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/";
        } else {
            $path_artWork = "/app/public/tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/";
            $path_thumb = "/app/public/tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/";
        }

        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);

        if (!file_exists(storage_path($path_artWork)))
            mkdir(storage_path($path_artWork), 0777, true);

        $artWork->fit(375, 250)->save(storage_path($path_artWork) . $image_name);
        $artWork_webp->fit(375, 250)->save(storage_path($path_artWork) . $image_name_wepb . ".webp");

        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);
        $thumb_webp->fit(142, 166)->save(storage_path($path_thumb) . $image_name_wepb . ".webp");

        if (isset($data['is_national'])) {
            $data['artwork_url'] = "tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/$image_name";
            $data['thumb_url'] = "tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/";
        } else {
            $data['artwork_url'] = "tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/$image_name";
            $data['thumb_url'] = "tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/$image_name";
        }

        return $data;
    }


    public function status($data)
    {
        if (isset($data['status'])) return true;

        return false;
    }


    public function statusChangetoString($albums)
    {
        foreach ($albums as $album) {
            if ($album->status) $album['status'] = 'on';
            else $album['status'] = 'off';
        }
    }



    public function type($data)
    {
        $album = new Album();

        if (isset($data['type']))
            $data['type'] = $album->getTypes()[$data['type']];

        return $data;
    }



    public function dateFormateForIndex($albums)
    {
        $added_dates = [];
        $release_dates = [];

        foreach ($albums as $album)
            $added_dates[$album->id] = Carbon::parse($album->added_date)->format('d-m-Y');

        foreach ($albums as $album)
            $release_dates[$album->id] = Carbon::parse($album->release_date)->format('d-m-Y');


        return [$added_dates, $release_dates];
    }

    public function dateFormat($data)
    {
        if (isset($data['added_date']))
            $data['added_date'] = Carbon::parse($data['added_date'])->format('Y/m/d h:m A');
        else $data['added_date'] = Carbon::now();
        if (isset($data['release_date']))
            $data['release_date'] = Carbon::parse($data['release_date'])->format('Y/m/d h:m A');
        else $data['release_date'] = Carbon::now();

        return $data;
    }
}