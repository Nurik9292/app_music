<?php

namespace App\Services\Admin\Track;

use App\Models\Track;

class Service
{

    private $track;
    private $managerTrack;

    public function __construct()
    {
        $this->track = new ScanCreateTrack();
        $this->managerTrack = new ManagerTrack();
    }

    public function store($data)
    {
        // $data = $this->saveTrack($data);
        $data = $this->managerTrack->saveTrack($data);

        if ($data['title'] == null)
            $data['title'] = 'none';

        $data['thumb_url'] = $this->managerTrack->resize($data['thumb_url']);

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
                $data = $this->managerTrack->saveTrack($data, $track);
                $data['thumb_url'] = $this->managerTrack->move($track->thumb_url);
            } elseif (isset($data['album'])) {
                if (count($track->album) == 0 || $data['album'] != $track->album[0]->id) {
                    $data = $this->managerTrack->saveTrack($data, $track);
                    $data['thumb_url'] = $this->managerTrack->move($track->thumb_url);
                }
            } elseif (!$track->where('audio_url', 'like', $data['audio_url']))
                $data = $this->managerTrack->saveTrack($data, $track);
        }

        if (isset($data['thumb_url']) && $data['thumb_url'] != $track->audio_url)
            $data['thumb_url'] = $this->managerTrack->resize($data['thumb_url']);

        if ($track->artists[0]->id == $data['artists'][0] && (count($track->album) > 0 && $track->album[0]->id == $data['album']))
            if (isset($data['thumb_url']))
                $data['thumb_url'] = $this->managerTrack->resize($data['thumb_url']);

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



    public function startScanDir($path, $local)
    {
        return $this->track->start($path, $local);
    }
}