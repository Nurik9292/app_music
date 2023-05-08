<?php

namespace App\Services\Admin\Artist;

use App\Models\Artist;
use App\Models\Country;
use App\Services\Admin\HelperService;
use Carbon\Carbon;
use GuzzleHttp\Client;
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

        $data['status'] = $this->status($data);

        Artist::firstOrCreate(['name' => $data['name']], $data);
    }

    public function update($data, $artist)
    {
        if ($data['artwork_url'])
            $data = $this->resize($data, $artist);

        $artist->update($data);
    }


    public function resize($data, $artist = null)
    {
        $path = $this->helper->pathImageForServer;

        if (!empty($data['country_id'])) {
            $country = Country::where("id", $data['country_id'])->get();
            $country = $country[0]->name;
        } else $country = 'Туркменния';


        if (isset($artist)) {
            $path_artist = $artist->artwork_url;
            $path_artist = substr($path, 0, strpos($path, basename($path)));
            $path_artist = $path . substr($path, strpos($path, "images"), strlen($path));

            $this->delete($path_artist);
        }

        if (is_string($data['artwork_url'])) {
            $image_name = basename($data['artwork_url']);

            $client = new Client();
            $res = $client->get($data['artwork_url']);
            $image = $res->getBody()->getContents();
        } else {
            $image_name = $data['artwork_url']->getClientOriginalName();
            $image = $data['artwork_url'];
        }

        if (is_string($image)) {
            $image_name_jpg = substr($image_name, 0, strpos($image_name, "webp") - 1);
        } else {
            if (str_ends_with($image_name, "png"))
                $image_name_wepb = substr($image_name, 0, strpos($image_name, "png") - 1);
            if (str_ends_with($image_name, "jpg"))
                $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpg") - 1);
            if (str_ends_with($image_name, "jpeg"))
                $image_name_wepb = substr($image_name, 0, strpos($image_name, "jpeg") - 1);
        }


        $artWork =  Image::make($image);
        $artWork_webp =  Image::make($image);

        $thumb = Image::make($image);
        $thumb_webp = Image::make($image);

        if ($country == 'Туркмения') {
            $path_artWork = "$path/tm_tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "$path/tm_tracks/{$data['name']}/artist_thumb/";
        } else {
            $path_artWork = "$path/tracks/{$data['name']}/artist_artWork/";
            $path_thumb = "$path/tracks/{$data['name']}/artist_thumb/";
        }

        // if (!file_exists(storage_path($path_thumb)))
        //     mkdir(storage_path($path_thumb), 0777, true);

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);

        // if (!file_exists(storage_path($path_artWork)))
        //     mkdir(storage_path($path_artWork), 0777, true);

        if (!file_exists($path_artWork))
            mkdir($path_artWork, 0777, true);


        if (is_string($image)) {
            $artWork->fit(375, 250)->save($path_artWork . $image_name_jpg . '.jpg');
            $artWork_webp->fit(375, 250)->save($path_artWork . $image_name);

            $thumb->fit(142, 166)->save($path_thumb . $image_name_jpg . '.jpg');
            $thumb_webp->fit(142, 166)->save($path_thumb . $image_name);
        } else {
            $artWork->fit(375, 250)->save($path_artWork . $image_name);
            $artWork_webp->fit(375, 250)->save($path_artWork . $image_name_wepb . ".webp");

            $thumb->fit(142, 166)->save($path_thumb . $image_name);
            $thumb_webp->fit(142, 166)->save($path_thumb . $image_name_wepb . ".webp");
        }

        if ($country == 'Туркменния') {
            $data['artwork_url'] = "https://storage2.ma.st.com.tm/images/tm_tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = "https://storage2.ma.st.com.tm/images/tm_tracks/{$data['name']}/artist_artWork/$image_name";
        } else {
            $data['artwork_url'] = "https://storage2.ma.st.com.tm/images/tracks/{$data['name']}/artist_artWork/$image_name";
            $data['thumb_url'] = "https://storage2.ma.st.com.tm/images/tracks/{$data['name']}/artist_thumb/$image_name";
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
}
