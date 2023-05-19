<?php

namespace App\Services\Admin\Track;

use App\Models\Track;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

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

        if (isset($data['artists']))
            $artists = $data['artists'];
        unset($data['artists']);


        if (isset($data['genres']))
            $genres = $data['genres'];
        unset($data['genres']);


        if (isset($data['album']))
            $album = $data['album'];
        unset($data['album']);


        $track = Track::create($data);

        if (isset($artists) && $genres != null)
            $track->artists()->attach($artists);
        if (isset($genres) && $genres != null)
            $track->genres()->attach($genres);
        if (isset($album) && $album != null)
            $track->album()->attach($album);
    }

    public function updata($data, $track)
    {
        $albumId = count($track->album) > 0 ? $track->album[0]->id : null;
        $artists = is_array($data['artists']) ? $data['artists'][0] : $data['artists'];
        $album = $data['album'] == 'null' ? null : $data['album'];


        if ($data['artwork_url'] instanceof UploadedFile) {
            $this->managerTrack->deleteForUpdated($track);
            $data['artwork_url'] = $this->managerTrack->resize($data['artwork_url'], $track);
        }

        Log::debug($album != $albumId);
        Log::debug($data['genres'] . " genres");

        if ($artists != $track->artists[0]->id || ($album != null && $album != $albumId) || $data['title'] != $track->title)
            $data = $this->managerTrack->saveTrack($data, $track);


        unset($data['artists']);
        unset($data['album']);

        if (isset($data['genres']) && $data['genres'] != null)
            $genres = $data['genres'];
        unset($data['genres']);

        $track->update($data);

        $track->artists()->sync($artists);
        if (isset($album) && $album != null)
            $track->album()->sync($album);
        if (isset($genres) && $genres != null)
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
