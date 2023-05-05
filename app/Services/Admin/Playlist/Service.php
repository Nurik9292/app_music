<?php

namespace App\Services\Admin\Playlist;

use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Service
{

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

        $playlist->update($data);

        $playlist->tracks()->sync($tracks);
        $playlist->genres()->sync($genres);
    }


    private function resize($data, $playlist = null)
    {
        $path = "/nfs/storage2/images";

        if (isset($playlist)) {
            $path_playlist = $playlist->artwork_url;
            $path_playlist = substr($path, 0, strpos($path, basename($path)));
            $path_playlist = '/nfs/storage2/' . substr($path, strpos($path, "images"), strlen($path));

            $this->delete($path_playlist);
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

        $data['artwork_url'] = "https://storage2.ma.st.com.tm/images/playlists/{$data['title_ru']}/playlist_artWork/$image_name";
        $data['thumb_url'] = "https://storage2.ma.st.com.tm/images/playlists/{$data['title_ru']}/playlist_thumb/$image_name";

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
}