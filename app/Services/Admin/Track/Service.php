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
    private $path;

    public function store($data)
    {
        $data = $this->saveTrack($data);

        $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        $genres = $data['genres'];
        unset($data['genres']);

        $album = $data['album'];
        unset($data['album']);
        dd($data);
        $track = Track::create($data);

        $track->artists()->attach($artists);
        $track->genres()->attach($genres);
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
        $artist = Artist::where('id', $data['artists'][0])->get();
        if (isset($artist))
            $name_artist = $artist[0]->name;
        else
            $name_artist = $data['artists'][0];

        if (!isset($data['is_national'])) {
            $album = Album::where('id', $data['album'][0])->get();
            $type_album = $album[0]->type;
            $name_album = $album[0]->title;
        }

        if (isset($track))
            Storage::disk('public')->delete($track->audio_url);

        $client = new Client();

        $res = $client->get($data['audio_url']);

        $audio = $res->getBody()->getContents();

        if (!isset($data['is_national'])) {
            $path = "tracks/{$name_artist}/{$type_album}/{$name_album}/"  . $data['title'] . '.mp3';
            $this->path = "tracks/{$name_artist}/{$type_album}/{$name_album}/";
        } else {
            $path = "tm_tracks/{$name_artist}/" . $data['title'] . '.mp3';
            $this->path = "tm_tracks/{$name_artist}/";
        }

        Storage::disk('public')->put($path, $audio);

        $track = new GetId3(storage_path("app/public/$path"));

        if ($track->getPlaytimeSeconds() != null)
            $data['duration'] =  intval(round($track->getPlaytimeSeconds()));

        $data['bit_rate'] = intval(round($track->extractInfo()['bitrate']));

        if (empty($data['track_number']))
            $data['track_number'] = $track->getTrackNumber();

        $data['audio_url'] = $path;

        return $data;
    }



    // public function saveTrack($data, $track = null)
    // {

    //     $artist = Artist::where('id', $data['artists'][0])->get();

    //     $path_artist = $artist[0]->name;

    //     if (isset($track))
    //         Storage::disk('public')->delete($track->audio_url);

    //     $track = new GetId3($data['audio_url']);

    //     if ($track->getPlaytimeSeconds() != null)
    //         $data['duration'] =  intval(round($track->getPlaytimeSeconds()));

    //     $data['bit_rate'] = intval(round($track->extractInfo()['bitrate']));

    //     if (empty($data['track_number']))
    //         $data['track_number'] = $track->getTrackNumber();

    //     $data['audio_url'] = Storage::disk('public')->putFileAs("tracks/{$path_artist}", $data['audio_url'], $track_name);

    //     return $data;
    // }


    public function resize($image, $track = null)
    {
        $image_name = $image->getClientOriginalName();


        if (isset($track))
            Storage::disk('public')->delete([$track->thumb_url]);


        $thumb =  Image::make($image);
        $webp = Image::make($image)->encode('webp');

        $path_thumb = "/app/public/{$this->path}";

        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);


        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);
        $webp->fit(142, 166)->save(storage_path($path_thumb) . $webp->basename . '.webp');

        $image = $this->path . $image_name;

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