<?php

namespace App\Services\Admin\Album;

use Carbon\Carbon;
use App\Models\Album;
use App\Models\Artist;
use App\Services\Admin\HelperService;
use Intervention\Image\Facades\Image;


class Service
{
    private $helper;

    public function __construct()
    {
        $this->helper  = new HelperService();
    }


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
        $data = $this->type($data);

        if (isset($data['artwork_url']))
            $data = $this->resize($data, $album);

        if ($data['title'] != $album->title || $data['artists'][0] != $album->artists[0]->id || $data['type'] != $album->type)
            $data = $this->move($data, $album);

        if (isset($data['added_date']) || isset($data['release_date']))
            $data = $this->dateFormat($data);

        $data['status'] = $this->status($data);

        if (isset($data['artists'])) {
            $artists = $data['artists'];
            unset($data['artists']);
        }

        $album->update($data);

        if ($artists)
            $album->artists()->sync($artists);
    }


    private function resize($data, $album = null)
    {
        $path = $this->helper->pathImageForServer;

        if (isset($data['artists']))
            $arist = Artist::where('id', $data['artists'][0])->get();
        $arist_name = $arist[0]->name ?? $album->artists[0]->name;

        if (isset($album)) {
            $path_temp = $this->helper->pathImageForServer;
            $pathImage = $album->artwork_url;
            $pathImage = $path_temp . substr($pathImage, strpos($pathImage, "images"));
            $pathImage = substr($pathImage, 0, strpos($pathImage,  "album_artWork/" . basename($pathImage)));
            $pathImage = preg_replace('/images\//', '', $pathImage);
            $this->delete($pathImage);
            unset($path_temp);
        }

        if (isset($data['artwork_url']))
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
            $path_artWork = "$path/tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/";
            $path_thumb = "/$path/tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/";
        } else {
            $path_artWork = "/$path/tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/";
            $path_thumb = "/$path/tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/";
        }

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);

        if (!file_exists($path_artWork))
            mkdir($path_artWork, 0777, true);

        $artWork->fit(375, 250)->save($path_artWork . $image_name);
        $artWork_webp->fit(375, 250)->save($path_artWork . $image_name_wepb . ".webp");

        $thumb->fit(142, 166)->save($path_thumb . $image_name);
        $thumb_webp->fit(142, 166)->save($path_thumb . $image_name_wepb . ".webp");

        $data = $this->getPathForDataBase($data, $arist_name, $image_name);

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

    public function delete($path)
    {
        dd(is_dir($path));
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    public function move($data, $album)
    {

        $artist = Artist::where("id", $data['artists'][0])->get();
        $arist_name = $album->artists[0]->id == $data['artists'][0] ? $album->artists[0]->name : $artist[0]->name;
        $image_name = basename($album->artwork_url);

        $data = $this->getPathForDataBase($data, $arist_name, $image_name);

        if (isset($data['is_national']))
            $new_path = $this->helper->pathImageForServer . "tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/";
        else
            $new_path = $this->helper->pathImageForServer . "tracks/{$arist_name}/{$data['type']}/{$data['title']}/";

        $image = substr($album->artwork_url, strpos($album->artwork_url, 'images'));
        $path =  $this->helper->pathImageForServer . substr($image,  strpos($image, 'images'));
        $path = substr($path, 0, strpos($path, "album_artWork/" . basename($path)));
        $path = preg_replace('/images\//', '', $path);

        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            if (!file_exists($new_path))
                mkdir($new_path, 0777, true);

            foreach ($files as $file) {
                rename($path . $file, $new_path . $file);
            };
        }

        return $data;
    }

    private function getPathForDataBase($data, $arist_name, $image_name)
    {
        if (isset($data['is_national'])) {
            $data['artwork_url'] = $this->helper->pathImageForDb . "tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/$image_name";
            $data['thumb_url'] = $this->helper->pathImageForDb . "tm_tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/$image_name";
        } else {
            $data['artwork_url'] = $this->helper->pathImageForDb . "tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_artWork/$image_name";
            $data['thumb_url'] = $this->helper->pathImageForDb . "tracks/{$arist_name}/{$data['type']}/{$data['title']}/album_thumb/$image_name";
        }

        return $data;
    }
}
