<?php

namespace App\Services\Admin\Artist;

use App\Models\Artist;
use App\Models\Country;
use App\Models\User;
use App\Services\Admin\HelperService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;


class Service
{
    private $helper;

    public function __construct()
    {
        $this->helper = new HelperService();
    }


    public function store($data)
    {
        $data = $this->resize($data);

        // $data['status'] = $this->status($data);

        Artist::firstOrCreate(['name' => $data['name']], $data);
    }

    public function update($data, $artist)
    {
        if (isset($data['artwork_url']) && $data['artwork_url'] != 'null')
            $data = $this->resize($data, $artist);

        if ($data['name'] != $artist->name)
            $data = $this->move($data, $artist);

        $artist->update($data);
    }


    public function resize($data, $artist = null)
    {
        $path = $this->helper->pathImageForServer;

        if (isset($artist)) {
            $path_temp = $this->helper->pathImageForServer;
            $pathImage = $artist->artwork_url;
            $pathImage = substr($pathImage, 0, strpos($pathImage, "artist_artWork/" . basename($pathImage)));
            $pathImage = pathToServer() . substr($pathImage, strpos($pathImage, "images"), strlen($pathImage));
            $pathImage = preg_replace('/images\//', '', $path);
            $this->delete($pathImage);
            unset($path_temp);
        }


        $image_name = $data['artwork_url']->getClientOriginalName();
        $image = $data['artwork_url'];

        if (str_ends_with($image_name, "png"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "png") - 1);
        if (str_ends_with($image_name, "jpg"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpg") - 1);
        if (str_ends_with($image_name, "jpeg"))
            $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpeg") - 1);


        $artWork =  Image::make($image);
        $artWork_webp =  Image::make($image);

        $thumb = Image::make($image);
        $thumb_webp = Image::make($image);



        if ($this->getCountry($data) == 'Туркмения') {
            $path_artWork = "$path/tm_tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "$path/tm_tracks/{$data['name']}/artist_thumb/";
        } else {
            $path_artWork = "$path/tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "$path/tracks/{$data['name']}/artist_thumb/";
        }

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);

        if (!file_exists($path_artWork))
            mkdir($path_artWork, 0777, true);


        $artWork->fit(375, 250)->save($path_artWork . $image_name);
        $artWork_webp->fit(375, 250)->save($path_artWork . $image_name_wepb . ".webp");

        $thumb->fit(142, 166)->save($path_thumb . $image_name);
        $thumb_webp->fit(142, 166)->save($path_thumb . $image_name_wepb . ".webp");


        $data = $this->getPathForDataBase($data, $image_name);

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


    public function delete($path)
    {

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

    public function move($data, $artist)
    {
        $image_name = basename($artist->artwork_url);

        $data = $this->getPathForDataBase($data, $image_name);

        if ($this->getCountry($data) == 'Туркмения')
            $new_path = $this->helper->pathImageForServer . "tm_tracks/{$data['name']}/";
        else
            $new_path = $this->helper->pathImageForServer . "tracks/{$data['name']}/";

        $image = substr($artist->artwork_url, strpos($artist->artwork_url, 'images'));
        $path =  pathToServer() . substr($image,  strpos($image, 'images'));
        $path = substr($path, 0, strpos($path, 'artist_artWork/' . basename($path)));

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

    private function getPathForDataBase($data, $image_name)
    {
        if ($this->getCountry($data) == 'Туркмения') {
            $data['artwork_url'] = $this->helper->pathImageForDb . "tm_tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = $this->helper->pathImageForDb . "tm_tracks/{$data['name']}/artist_thumb/$image_name";
        } else {
            $data['artwork_url'] = $this->helper->pathImageForDb . "tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = $this->helper->pathImageForDb . "tracks/{$data['name']}/artist_thumb/$image_name";
        }

        return $data;
    }

    private function getCountry($data)
    {
        if (!empty($data['country_id'])) {
            $country = Country::where("id", $data['country_id'])->get();
            $country = $country[0]->name;
        } else $country = 'Туркмения';

        return $country;
    }
}