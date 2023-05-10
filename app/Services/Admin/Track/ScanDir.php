<?php

namespace App\Services\Admin\Track;

use App\Models\File;
use App\Services\Admin\HelperService;
use Carbon\Carbon;
use DirectoryIterator;
use getID3;

class ScanDir
{

    private $data;
    private $mp3;
    private $wepb;
    private $helper;

    public function __construct()
    {
        $this->helper = new HelperService();
    }

    public function getContentDir($path, $local)
    {
        if (str_starts_with($path, "https://storage2.ma.st.com.tm:1000/files/"))
            $path = $this->helper->pathTrackForServer . preg_replace('/(https:\/\/storage2.ma.st.com.tm:1000\/files\/)/', '', $path);

        $file = File::where('local', $local)->get();

        $iter = new DirectoryIterator($path);

        foreach ($iter as $item) {
            if ($item != '.' && $item != '..') {
                if ($item->isDir()) $this->getContentDir($path . $item->getBasename() . "/", $local);

                if ($item->isFile()) {
                    if ($file[0]->scanTime <= Carbon::parse($item->getATime())->format('Y-m-d H:i')) {
                        str_ends_with($item->getBasename(), 'mp3') ? $this->mp3[] = $item->getRealPath() : '';
                        str_ends_with($item->getBasename(), 'webp') ? $this->wepb[] = $item->getRealPath() : '';
                    }
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
        $track = new getID3;


        foreach ($this->mp3 as $audio_url) {
            $track = new getID3;
            // dd(isset($track->analyze($audio_url)['tags']['id3v1']), $track->analyze($audio_url));
            if (isset($track->analyze($audio_url)['tags']['id3v1'])) {
                $artist = $track->analyze($audio_url)['tags']['id3v1']['artist'][0];
                $title = $track->analyze($audio_url)['tags']['id3v1']['title'][0];
                $album = $track->analyze($audio_url)['tags']['id3v1']['album'][0];
            }
            $bitrate = intval(round($track->analyze($audio_url)['bitrate']));
            $duration = intval(round($track->analyze($audio_url)['playtime_seconds']));

            $this->data[] = [
                'title' => isset($title) ? $title : '',
                'artists' => isset($artist) ? $artist : '',
                'album' => isset($album) ? $album : '',
                'duration' => $duration,
                'bit_rate' => $bitrate,
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
        foreach ($this->wepb as $image_url) {
            $image_name = substr(basename($image_url), 0, strpos(basename($image_url), '.webp'));
            $audio_name = substr(basename($audio_url), 0, strpos(basename($audio_url), '.mp3'));
            if ($image_name == $audio_name) return $image_url;
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
}