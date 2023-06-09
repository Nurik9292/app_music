<?php

namespace App\Services\Admin\Track;

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Owenoj\LaravelGetId3\GetId3;
use App\Services\Admin\HelperService;
use Intervention\Image\Facades\Image;

class ManagerTrack
{
    private $helper;

    private $path_first;
    private $path_second;


    public function __construct()
    {
        $this->helper = new HelperService();
        $this->path_first = $this->helper->pathImageForServer;
    }




    public function saveTrack($data, $track = null)
    {
        $type_album = null;
        $name_album = null;

        $item = new GetId3($data['audio_url']);

        if ($item->getPlaytimeSeconds() != null)
            $data['duration'] =  intval(round($item->getPlaytimeSeconds()));

        $data['bit_rate'] = intval(round($item->extractInfo()['bitrate']));

        if (!isset($data['track_number']) && $item->getTrackNumber() != null)
            $data['track_number'] = $item->getTrackNumber();

        $data['audio_url'] = preg_replace('/:1000\/files/', '', $data['audio_url']);

        if (isset($data['artists']) && $data['artists'] != null) {
            $artist = Artist::where('id', $data['artists'][0])->get();
            $name_artist = $artist[0]->name;
        } else {
            $name_artist = $item->getArtist() ?? "none";
        }

        if (isset($data['album']) && $data['album'] != null)
            [$type_album, $name_album] = $this->albumPath($data);

        $this->pathForSecond($data['is_national'], $name_artist, $type_album, $name_album, $data['title']);

        $data['title'] = preg_replace('/(.mp3)/', '', basename($data['audio_url']));
        $data['artwork_url'] = $this->resize($item->getArtwork(true));


        return $data;
    }


    public function resize($image, $track = null,  $data = null)
    {
        $user = User::where('id', $data['user_id'])->get()[0];
        $moderator = 3;

        $image_name = $image->getClientOriginalName();
        $image_name_base = substr($image_name, 0, strpos($image_name, '.'));


        if (isset($track)) {
            if ($user->role !== $moderator) {
                $this->deleteForUpdated($track);
            }


            $this->pathForSecond(
                $track->is_national,
                count($track->artists) > 0 ? $track->artists[0]->name : '',
                count($track->album) > 0 ? $track->album[0]->type : '',
                count($track->album) > 0 ? $track->album[0]->title : '',
                $user->role !== $moderator ? $track->title : $track->title . '_2/'
            );
        }

        $artwork = Image::make($image);
        $artwork_webp =  Image::make($image)->encode('webp');

        $thumb = Image::make($image);
        $thumb_webp =  Image::make($image)->encode('webp');

        $path_artwork = $this->path_first . $this->path_second . "artwork/";
        $path_thumb = $this->path_first . $this->path_second . "thumb/";

        if (!file_exists($path_artwork))
            mkdir($path_artwork, 0777, true);
        else
            mkdir(preg_replace('/(_2\/)/', '', $path_artwork), 0777, true);

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);
        else
            mkdir(preg_replace('/(_2    \/)/', '', $path_artwork), 0777, true);



        $thumb->fit(142, 166)->save($path_thumb . $image_name);
        $thumb_webp->fit(142, 166)->save($path_thumb . $image_name_base . '.webp')->encode('webp');

        $artwork->fit(142, 166)->save($path_artwork . $image_name);
        $artwork_webp->fit(142, 166)->save($path_artwork . $image_name_base . '.webp')->encode('webp');

        if (isset($track)) {
            $data['artwork_url'] = $this->helper->pathImageForDb . $this->path_second . 'artwork/' . $image_name;
            $data['thumb_url'] = $this->helper->pathImageForDb . $this->path_second . 'thumb/' . $image_name;
            return $data;
        }

        return $image;
    }


    public function move($path)
    {
        $image = $this->helper->pathImageForDb . $this->path_second . basename($path);

        $path = substr($path, 0, strpos($path, basename($path)));

        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            if (!file_exists($this->path_first . $this->path_second))
                mkdir($this->path_first . $this->path_second, 0777, true);

            foreach ($files as $file) {
                rename($path . $file, $this->path_first . $this->path_second . $file);
            };
        }

        return $image;
    }

    public function movingImage($data, $track)
    {
        $path = $track->artwork_url;
        $user = User::where('id', $data['user_id'])->get()[0];
        $moderator = 3;

        $artist = Artist::where('id', $data['artists'][0])->get();
        $album = Album::where('id', $data['album'])->get();

        $this->pathForSecond(
            $track->is_national,
            count($artist) > 0 ? $artist[0]->name : '',
            count($album) > 0 ? $album[0]->type : '',
            count($album) > 0 ? $album[0]->title : '',
            $track->title
        );

        $data['artwork_url'] = $this->helper->pathImageForDb . $this->path_second . 'artwork/' . basename($track->artwork_url);
        $data['thumb_url'] = $this->helper->pathImageForDb . $this->path_second . 'thumb/' . basename($track->thumb_url);

        $path = substr($path, 0, strpos($path, basename($path)));

        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            if (!file_exists($this->path_first . $this->path_second))
                mkdir($this->path_first . $this->path_second, 0777, true);

            foreach ($files as $file) {
                if ($user->role !== $moderator)
                    rename($path . $file, $this->path_first . $this->path_second . $file);
                else
                    copy($path . $file, $this->path_first . $this->path_second . $file);
            };
        }

        return $data;
    }


    private function albumPath($data)
    {
        if ($data['album'] != null) {
            $album = Album::where('id', $data['album'])->get();
            $type_album = $album[0]->type ?? '';
            $name_album = $album[0]->title ?? '';
            return [$type_album, $name_album];
        }
    }

    public function deleteForUpdated($track)
    {
        $path = $track->artwork_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = pathToServer() . substr($path, strpos($path, "images"));

        $path = preg_replace('/artwork\//', '', $path);

        (new Service)->delete($path);
    }

    private function pathForSecond($local, $name_artist, $type_album, $name_album, $title)
    {
        if ($local == 'tm') {
            $path = "tm_tracks/{$name_artist}/{$type_album}/{$name_album}/{$title}/";
        } else {
            $path = "tracks/{$name_artist}/{$type_album}/{$name_album}/{$title}/";
        }
        $this->path_second .= preg_replace('/(\/)(?=\1)/', '', $path);
    }
}
