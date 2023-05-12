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
        $data = $this->managerTrack->saveTrack($data);

        if ($data['title'] == null)
            $data['title'] = 'none';

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

        if ($data['artists'][0] != $track->artists[0]->id || $data['album'] != $track->album[0]->id || $data['title'] != $track->title)
            $data = $this->managerTrack->saveTrack($data, $track);


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