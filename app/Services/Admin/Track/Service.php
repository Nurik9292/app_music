<?php

namespace App\Services\Admin\Track;

use App\Models\Album;
use App\Models\Track;
use App\Models\Artist;
use GuzzleHttp\Client;
use Owenoj\LaravelGetId3\GetId3;
use App\Services\Admin\HelperService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Service
{

    private $helper;
    private $track;

    private $path_first;
    private $path_second;
    private $scanDir;

    public function __construct()
    {
        $this->scanDir = new ScanDir();
        $this->helper = new HelperService();
        $this->track = new ScanCreateTrack();
        $this->path_first = $this->helper->pathImageForServer;
    }

    public function store($data)
    {
        $data = $this->saveTrack($data);

        if ($data['title'] == null)
            $data['title'] = 'none';

        $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        if (isset($data['genres']) && $data['genres'] != '0')
            $genres = $data['genres'];
        unset($data['genres']);


        if (isset($data['album']) && $data['album'] != '0')
            $album = $data['album'];
        unset($data['album']);


        $track = Track::create($data);

        $track->artists()->attach($artists);
        if (isset($genres) && $genres != '0')
            $track->genres()->attach($genres);
        if (isset($album) && $album != '0')
            $track->album()->attach($album);
    }

    public function updata($data, $track)
    {
        if (isset($data['audio_url'])) {
            if (count($track->artists) > 0 && $track->artists[0]->id != $data['artists'][0]) {
                $data = $this->saveTrack($data, $track);
                $data['thumb_url'] = $this->move($track->thumb_url);
            } elseif (isset($data['album'])) {
                if (count($track->album) == 0 || $data['album'] != $track->album[0]->id) {
                    $data = $this->saveTrack($data, $track);
                    $data['thumb_url'] = $this->move($track->thumb_url);
                }
            } elseif (!$track->where('audio_url', 'like', $data['audio_url']))
                $data = $this->saveTrack($data, $track);
        }

        if (isset($data['thumb_url']) && $data['thumb_url'] != $track->audio_url)
            $data['thumb_url'] = $this->resize($data['thumb_url']);

        if ($track->artists[0]->id == $data['artists'][0] && (count($track->album) > 0 && $track->album[0]->id == $data['album']))
            if (isset($data['thumb_url']))
                $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        if (isset($data['genres']) && $data['genres'] != '0')
            $genres = $data['genres'];
        unset($data['genres']);


        if (isset($data['album']) && $data['album'] != '0')
            $album = $data['album'];
        unset($data['album']);

        $track->update($data);

        $track->artists()->sync($artists);
        if (isset($album) && $album != '0')
            $track->album()->sync($album);
        if (isset($genres) && $genres != '0')
            $track->genres()->sync($genres);
    }


    public function saveTrack($data, $track = null)
    {

        if (isset($data['artists']) && $data['artists'] != null) {
            $artist = Artist::where('id', $data['artists'][0])->get();
            $name_artist = $artist[0]->name;
        }

        list($type_album, $name_album) = $this->albumPath($data);

        $audio = $this->getContent($data['audio_url']);

        $data['title'] = basename($data['audio_url']);

        if (isset($data['is_national'])) {
            if ($data['album'] != '0')
                $this->path_second .= "tm_tracks/{$name_artist}/{$type_album}/{$name_album}/{$data['title']}/";
            else
                $this->path_second .= "tm_tracks/{$name_artist}/{$data['title']}/";
        } else {
            if ($data['album'] != '0') {
                $this->path_second .= "tracks/{$name_artist}/{$type_album}/{$name_album}/{$data['title']}/";
            } else {
                $this->path_second .= "tracks/{$name_artist}/{$data['title']}/";
            }
        }

        if ($track == null || $track->audio_url != $data['audio_url']) {
            Storage::disk('public')->put("tracks/{$data['title']}", $audio);

            $track = new GetId3(storage_path("app/public/tracks/{$data['title']}"));

            if ($track->getPlaytimeSeconds() != null)
                $data['duration'] =  intval(round($track->getPlaytimeSeconds()));

            $data['bit_rate'] = intval(round($track->extractInfo()['bitrate']));

            if (!isset($data['track_number']) && $track->getTrackNumber() != null)
                $data['track_number'] = $track->getTrackNumber();

            Storage::disk('public')->delete("tracks/{$data['title']}");

            $data['audio_url'] = preg_replace('/:1000\/files/', '', $data['audio_url']);
        }

        return $data;
    }

    public function resize($image, $track = null)
    {
        if (is_string($image)) {
            $image_name = basename($image);
            $image = $this->getContent($image);
        } else {
            $image_name = $image->getClientOriginalName();
            $image_name_base = substr($image_name, 0, strpos($image_name, '.'));
        }

        if (isset($track))
            $this->deleteForUpdated($track);


        $thumb = Image::make($image)->encode('jpg');
        $webp =  Image::make($image)->encode('webp');

        $path_thumb = $this->path_first . $this->path_second;

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);

        if (is_string($image)) {
            $webp->fit(142, 166)->save($path_thumb . $image_name);
            $thumb->fit(142, 166)->save($path_thumb . $webp->basename . '.jpg');
        } else {
            $thumb->fit(142, 166)->save($path_thumb . $image_name);
            $webp->fit(142, 166)->save($path_thumb . $image_name_base . '.webp');
        }

        $image = $this->helper->pathImageForDb . $this->path_second . $image_name;

        return $image;
    }


    public function statusChangetoString($tracks)
    {
        foreach ($tracks as $track) {
            if ($track->status) $track['status'] = 'on';
            else $track['status'] = 'off';
        }
    }


    public function delete($path)
    {

        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), ['.', '..']);

            foreach ($files as $file) {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    public function move($path)
    {
        $image = $this->helper->pathImageForDb . $this->path_second . basename($path);
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = $this->helper->pathImageForServer . substr($path, strpos($path, "images"), strlen($path));
        $path = preg_replace('/images\//', '', $path);

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

    private function getContent($url)
    {
        $client = new Client();
        $res = $client->get($url);
        return $res->getBody()->getContents();
    }

    private function deleteForUpdated($track)
    {
        $path = $track->thumb_url;
        $path = substr($path, 0, strpos($path, basename($path)));
        $path = $this->helper->pathImageForServer . substr($path, strpos($path, "images"));
        $path = preg_replace('/images\//', '', $path);

        $this->delete($path);
    }

    private function albumPath($data)
    {
        // if (!isset($data['is_national'])) {
        if ($data['album'] != '0') {
            $album = Album::where('id', $data['album'])->get();
            $type_album = $album[0]->type;
            $name_album = $album[0]->title;
            return [$type_album, $name_album];
        }
        // }
    }


    public function startScanDir($path, $local)
    {
        $this->scanDir->getContentDir($path, $local);
        $this->scanDir->addContent($local);

        $data = $this->scanDir->getData();

        if ($data != null)
            $this->track->create($data);
    }
}