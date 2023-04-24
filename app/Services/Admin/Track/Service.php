<?php

namespace App\Services\Admin\Track;

use App\Models\Artist;
use App\Models\Track;
use Owenoj\LaravelGetId3\GetId3;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Service
{
    public function store($data)
    {
        $data = $this->saveTrack($data);

        $data['thumb_url'] = $this->resize($data['thumb_url']);

        $artists = $data['artists'];
        unset($data['artists']);

        $albumTrack['album_id'] = $data['album_id'];
        unset($data['album_id']);

        $genreTrack['genre_id'] = $data['genre_id'];
        unset($data['genre_id']);

        $track = Track::create($data);

        $track->artists()->attach($artists);
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
        $track_name = $data['audio_url']->getClientOriginalName();

        $artist = Artist::where('id', $data['artists'][0])->get();

        $path_artist = $artist[0]->name;

        if (isset($track))
            Storage::disk('public')->delete($track->audio_url);

        $track = new GetId3($data['audio_url']);

        $data['duration'] =  intval(round($track->getPlaytimeSeconds()));

        $data['bit_rate'] = intval(round($track->extractInfo()['bitrate']));

        if (empty($data['track_number']))
            $data['track_number'] = $track->getTrackNumber();

        $data['audio_url'] = Storage::disk('public')->putFileAs("tracks/{$path_artist}", $data['audio_url'], $track_name);

        return $data;
    }


    public function resize($image, $track = null)
    {
        if (isset($track))
            Storage::disk('public')->delete($track->thumb_url);

        $image_name = $image->getClientOriginalName();

        $thumb =  Image::make($image);

        $path_thumb = "/app/public/images/track/";

        if (!file_exists(storage_path($path_thumb)))
            mkdir(storage_path($path_thumb), 0777, true);

        $thumb->fit(142, 166)->save(storage_path($path_thumb) . $image_name);

        $image = "images/track/$image_name";

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