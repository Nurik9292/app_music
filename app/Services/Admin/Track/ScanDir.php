<?php

namespace App\Services\Admin\Track;

use App\Models\File;
use App\Services\Admin\HelperService;
use Carbon\Carbon;
use DirectoryIterator;
use Owenoj\LaravelGetId3\GetId3;

class ScanDir
{

    private $data;
    private $mp3;
    private $wepb;
    private $helper;
    private $timestamp;

    public function __construct()
    {
        $this->helper = new HelperService();
    }

    public function getContentDir($path, $local)
    {
        if (str_starts_with($path, "https://storage2.ma.st.com.tm:1000/files/"))
            $path = $this->helper->pathTrackForServer . preg_replace('/(https:\/\/storage2.ma.st.com.tm:1000\/files\/)/', '', $path);

        if (!str_ends_with($path, '/'))
            $path = $path . '/';

        $file = File::where('local', $local)->get();

        $iter = new DirectoryIterator($path);

        foreach ($iter as $item) {
            if ($item != '.' && $item != '..') {
                if ($item->isDir()) $this->getContentDir($path . $item->getBasename() . "/", $local);

                if ($item->isFile()) {

                    if ($file[0]->scanTime < $item->getATime()) {
                        if ($item->getSize() != 0) {
                            str_ends_with($item->getBasename(), '.mp3') ? $this->mp3[] = $item->getRealPath() : '';
                            str_ends_with($item->getBasename(), '.webp') ? $this->wepb[] = $item->getRealPath() : '';
                        }
                    }

                    $this->timestamp = $item->getATime();
                }
            }
        }
    }

    public function addContent($local)
    {
        if ($this->mp3 != null)
            $this->addMp3($local);
    }

    private function addMp3($local)
    {
        foreach ($this->mp3 as $audio_url) {

            $track = new GetId3($audio_url);

            $artist = $track->getArtist() ?? null;
            $title = $track->getTitle() ?? null;
            $album = $track->getAlbum() ?? null;
            if ($track->getPlaytimeSeconds())
                $duration = intval(round($track->getPlaytimeSeconds()));
            if (isset($track->extractInfo()['bitrate']))
                $bitrate = intval(round($track->extractInfo()['bitrate']));


            $this->data[] = [
                'title' => $title,
                'artists' => $artist,
                'album' => $album,
                'duration' => isset($duration) ? $duration : 0,
                'bit_rate' => isset($bitrate) ? $bitrate : 0,
                'lyrics' => '',
                'audio_url' => $audio_url,
                'is_national' => $local == 'tm' ? true : false,
                'thumb_url' => $this->addImage($audio_url),
                'status' =>  true
            ];
        }
    }


    private function addImage($audio_url)
    {
        if (!is_array($this->wepb)) {
            $image_name = substr(basename($this->wepb), 0, strpos(basename($this->wepb), '.webp'));
            $audio_name = substr(basename($audio_url), 0, strpos(basename($audio_url), '.mp3'));
            return $this->wepb;
        }

        foreach ($this->wepb as $key => $image_url) {
            $image_name = substr(basename($image_url), 0, strpos(basename($image_url), '.webp'));
            $audio_name = substr(basename($audio_url), 0, strpos(basename($audio_url), '.mp3'));
            if ($image_name == $audio_name) {
                unset($this->wepb[$key]);
                return $image_url;
            }
        }
    }




    public function getMp3()
    {
        return $this->mp3;
    }

    public function getWepb()
    {
        return $this->wepb;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}