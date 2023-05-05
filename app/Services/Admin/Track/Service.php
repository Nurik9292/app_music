<?php

namespace App\Services\Admin\Track;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use GuzzleHttp\Client;
use Owenoj\LaravelGetId3\GetId3;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Service
{
    private $path = '/home/nury/nfs/production/images/';

    public function store($data)
    {
        $data = $this->saveTrack($data);

        $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        if (isset($data['genres']) && $data['genres'] != null) {
            $genres = $data['genres'];
            unset($data['genres']);
        }

        if (isset($data['album']) && $data['album'] != null) {
            $album = $data['album'];
            unset($data['album']);
        }

        $track = Track::create($data);

        if (isset($data['artists']) && $data['artists'] != null)
            $track->artists()->attach($artists);
        if (isset($data['genres']) && $data['genres'] != null)
            $track->genres()->attach($genres);
        if (isset($data['album']) && $data['album'] != null)
            $track->album()->attach($album);
    }


    public function updata($data, $track)
    {

        if (isset($data['audio_url']))
            $data = $this->saveTrack($data, $track);

        if (isset($data['thumb_url']))
            $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        $albumTrack['album_id'] = $data['album_id'];
        unset($data['album_id']);


        $track->update($data);

        $track->artists()->sync($artists);
    }


    public function saveTrack($data, $track = null)
    {

        if (is_array($data['artists']))
            $artist = Artist::where('id', $data['artists'][0])->get();
        else
            $artist = Artist::where('name', 'like', $data['artists'])->get();


        if ($artist != null && count($artist) > 0) {
            $name_artist = $artist[0]->name;
        } else {
            if (is_array($data['artists'])) {
                $name_artist = $data['artists'][0];
            } else {
                $name_artist = $data['artists'];
            }
        }

        if (!isset($data['is_national'])) {
            if ($data['album'] != '0') {
                $album = Album::where('id', $data['album'])->get();
                $type_album = $album[0]->type;
                $name_album = $album[0]->title;
            }
        }

        if (isset($track))
            Storage::disk('public')->delete($track->audio_url);

        $client = new Client();
        $res = $client->get($data['audio_url']);
        $audio = $res->getBody()->getContents();

        $data['title'] = basename($data['audio_url']);

        if (isset($data['is_national'])) {
            $this->path .= "tm_tracks/{$name_artist}/{$data['title']}/";
        } else {
            if ($data['album'] != '0') {
                $this->path .= "tracks/{$name_artist}/{$type_album}/{$name_album}/{$data['title']}/";
            } else {
                $this->path .= "tracks/{$name_artist}/{$data['title']}/";
            }
        }

        Storage::disk('public')->put("tracks/{$data['title']}", $audio);

        $track = new GetId3(storage_path("app/public/tracks/{$data['title']}"));

        if ($track->getPlaytimeSeconds() != null)
            $data['duration'] =  intval(round($track->getPlaytimeSeconds()));

        $data['bit_rate'] = intval(round($track->extractInfo()['bitrate']));

        if (!isset($data['track_number']) && $track->getTrackNumber() != null)
            $data['track_number'] = $track->getTrackNumber();

        Storage::disk('public')->delete("tracks/{$data['title']}");

        return $data;
    }

    public function resize($image, $track = null)
    {
        if (is_string($image)) {
            $image_name = basename($image);
            $client = new Client();
            $res = $client->get($image);
            $image = $res->getBody()->getContents();
        } else {
            $image_name = $image->getClientOriginalName();
            $image_name_base = substr($image_name, 0, strpos($image_name, '.'));
        }

        if (isset($track))
            Storage::disk('public')->delete([$track->thumb_url]);


        $thumb = Image::make($image)->encode('jpg');
        $webp =  Image::make($image)->encode('webp');

        $path_thumb = $this->path;

        if (!file_exists($path_thumb))
            mkdir($path_thumb, 0777, true);

        if (is_string($image)) {
            $webp->fit(142, 166)->save($path_thumb . $image_name);
            $thumb->fit(142, 166)->save($path_thumb . $webp->basename . '.jpg');
        } else {
            $thumb->fit(142, 166)->save($path_thumb . $image_name);
            $webp->fit(142, 166)->save($path_thumb . $image_name_base . '.webp');
        }


        $image = $path_thumb . $image_name;
        // dd($image);
        return $image;
    }


    public function statusChangetoString($tracks)
    {
        foreach ($tracks as $track) {
            if ($track->status) $track['status'] = 'on';
            else $track['status'] = 'off';
        }
    }
}