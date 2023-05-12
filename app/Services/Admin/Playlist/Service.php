<?php

namespace App\Services\Admin\Playlist;

use App\Models\Playlist;
use App\Services\Admin\HelperService;
use Carbon\Carbon;
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

        $tracks = $data['tracks'];
        unset($data['tracks']);

        $genres = $data['genres'];
        unset($data['genres']);

        $playlist = Playlist::create($data);

        $playlist->tracks()->attach($tracks);
        $playlist->genres()->attach($genres);
    }


    public function update($data, $playlist)
    {
        if (isset($data['artwokr_url']))
            $data = $this->resize($data);

        if (isset($data['tracks'])) {
            $tracks = $data['tracks'];
            unset($data['tracks']);
        }

        if (isset($data['genres'])) {
            $genres = $data['genres'];
            unset($data['genres']);
        }

        $data['status'] = $this->status($data);

        if ($data['title_ru'] != $playlist->title_ru)
            $data = $this->move($data, $playlist);

        $playlist->update($data);

        $playlist->tracks()->sync($tracks);
        $playlist->genres()->sync($genres);
    }


    private function resize($data, $playlist = null)
    {
        $path = $this->helper->pathImageForServer;

        if (isset($playlist)) {
            $this->deleteForUpdate($playlist->thumb_url);
            $this->deleteForUpdate($playlist->artwork_url);
        }

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


        $path_artWork = "{$path}/playlists/{$data['title_ru']}/playlist_artWork/";
        $path_thumb = "{$path}//playlists/{$data['title_ru']}/playlist_thumb/";


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


    public function statusChangetoString($albums)
    {
        foreach ($albums as $album) {
            if ($album->status) $album['status'] = 'on';
            else $album['status'] = 'off';
        }
    }


    public function dateFormate($playlists)
    {
        $dates = [];

        foreach ($playlists as $playlist)
            $dates[$playlist->id] = Carbon::parse($playlist->created_at)->format('d-m-Y');

        return $dates;
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

    public function move($data, $playlist)
    {

        $image_name = basename($playlist->artwork_url);

        $data = $this->getPathForDataBase($data, $image_name);

        $new_path = $this->helper->pathImageForServer . "playlists/{$data['title_ru']}/";

        $image = substr($playlist->artwork_url, strpos($playlist->artwork_url, 'images'));
        $path = substr($image, 0, strpos($image, 'playlist_artWork/' . basename($image)));
        $path = pathToServer() . substr($path, strpos($path, "images"), strlen($path));

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

        $data['artwork_url'] = $this->helper->pathImageForDb . "playlists/{$data['title_ru']}/playlist_artWork/$image_name";
        $data['thumb_url'] = $this->helper->pathImageForDb . "playlists/{$data['title_ru']}/playlist_thumb/$image_name";

        return $data;
    }

    private function deleteForUpdate($image)
    {
        $path = substr($image, 0, strpos($image,  basename($image)));
        $path = $this->helper->pathImageForServer  . substr($path, strpos($path, "images"), strlen($path));
        $path = preg_replace('/images\//', '', $path);
        $this->delete($path);
    }
}